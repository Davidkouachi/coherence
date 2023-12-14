<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Events\NotificationAcorrective;
use App\Events\NotificationApreventive;
use App\Events\NotificationAnon;
use App\Events\NotificationProcessus;
use App\Events\NotificationRisque;
use App\Events\NotificationAup;
use App\Events\NotificationAm2;
use App\Events\NotificationAm3;

use App\Models\Processuse;
use App\Models\Amelioration;
use App\Models\Objectif;
use App\Models\Risque;
use App\Models\Cause;
use App\Models\Rejet;
use App\Models\Action;
use App\Models\Suivi_action;
use App\Models\Pdf_file;
use App\Models\Pdf_file_processus;
use App\Models\User;
use App\Models\Historique_action;
use App\Models\Poste;
use App\Models\Suivi_amelioration;

use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

use Twilio\Rest\Client;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ListeamController extends Controller
{
    public function index_validation()
    {
        $ams = Amelioration::where('statut', '!=', 'valider')->get();

        $actionsData = [];

        foreach ($ams as $am) {
            $am->nbre_action = Suivi_amelioration::where('amelioration_id', '=', $am->id)->count();

            $suivi = Suivi_amelioration::where('amelioration_id', '=', $am->id)->get();
            $actionsData[$am->id] = [];
            foreach ($suivi as $suivis) {

                if($suivis->type === 'action') {
                    $action= null;

                    $action = Suivi_amelioration::join('actions', 'suivi_ameliorations.action_id', 'actions.id')
                                                ->join('postes', 'actions.poste_id', 'postes.id')
                                                ->join('risques', 'actions.risque_id', 'risques.id')
                                                ->join('processuses', 'risques.processus_id', 'processuses.id')
                                                ->where('actions.id', '=', $suivis->action_id)
                                                ->select('suivi_ameliorations.*', 'actions.action as action', 'postes.nom as poste', 'processuses.nom as processus', 'risques.nom as risque')
                                                ->first();

                } else if($suivis->type !== 'action') {
                    $action = Suivi_amelioration::join('action_ams', 'suivi_ameliorations.action_id', 'action_ams.id')
                                                ->join('postes', 'action_ams.poste_id', 'postes.id')
                                                ->join('risque_ams', 'action_ams.risque_id_am', 'risque_ams.id')
                                                ->join('processuses', 'risque_ams.processus_id', 'processuses.id')
                                                ->where('action_ams.id', '=', $suivis->action_id)
                                                ->select('suivi_ameliorations.*', 'action_ams.action as action', 'postes.nom as poste', 'processuses.nom as processus', 'risque_ams.nom as risque')
                                                ->first();

                }

                if ($action) {
                    $actionsData[$am->id][] = [
                        'action' => $action->action,
                        'responsable' => $action->poste,
                        'delai' => $action->delai,
                        'date_action' => $action->date_action,
                        'date_suivi' => $action->date_suivi,
                        'statut' => $action->statut,
                        'processus' => $action->processus,
                        'risque' => $action->risque,
                        'commentaire' => $action->commentaire_am,
                    ];
                }

            }
        }

        return view('tableau.valideam', ['ams' => $ams, 'actionsData' => $actionsData ]);
    }

    public function index_amup()
    {
        $ams = Amelioration::all();

        $actionsData = [];

        foreach ($ams as $am) {
            $am->nbre_action = Suivi_amelioration::where('amelioration_id', '=', $am->id)->count();

            $suivi = Suivi_amelioration::where('amelioration_id', '=', $am->id)->get();
            $actionsData[$am->id] = [];
            foreach ($suivi as $suivis) {

                if($suivis->type === 'action') {
                    $action= null;

                    $action = Suivi_amelioration::join('actions', 'suivi_ameliorations.action_id', 'actions.id')
                                                ->join('postes', 'actions.poste_id', 'postes.id')
                                                ->join('risques', 'actions.risque_id', 'risques.id')
                                                ->join('processuses', 'risques.processus_id', 'processuses.id')
                                                ->where('actions.id', '=', $suivis->action_id)
                                                ->select('suivi_ameliorations.*', 'actions.action as action', 'postes.nom as poste', 'processuses.nom as processus', 'risques.nom as risque')
                                                ->first();

                } else if($suivis->type !== 'action') {
                    $action = Suivi_amelioration::join('action_ams', 'suivi_ameliorations.action_id', 'action_ams.id')
                                                ->join('postes', 'action_ams.poste_id', 'postes.id')
                                                ->join('risque_ams', 'actions.risque_id_am', 'risque_ams.id')
                                                ->join('processuses', 'risque_ams.processus_id', 'processuses.id')
                                                ->where('action_ams.id', '=', $suivis->action_id)
                                                ->select('suivi_ameliorations.*', 'action_ams.action as action', 'postes.nom as poste', 'processuses.nom as processus', 'risque_ams.nom as risque')
                                                ->first();

                }

                if ($action) {
                    $actionsData[$am->id][] = [
                        'action' => $action->action,
                        'responsable' => $action->poste,
                        'delai' => $action->delai,
                        'date_action' => $action->date_action,
                        'date_suivi' => $action->date_suivi,
                        'statut' => $action->statut,
                        'processus' => $action->processus,
                        'risque' => $action->risque,
                        'commentaire' => $action->commentaire_am,
                    ];
                }

            }
        }

        return view('traitement.amup', ['ams' => $ams, 'actionsData' => $actionsData ]);
    }

    public function am_valider($id)
    {
        $valide = Amelioration::where('id', $id)->first();

        if ($valide)
        {

            $valide->date_validation = now()->format('Y-m-d\TH:i');
            $valide->statut = 'valider';
            $valide->update();

            if ($valide) {

                $his = new Historique_action();
                $his->nom_formulaire = 'Validation fiche amelioration';
                $his->nom_action = 'Valider';
                $his->user_id = Auth::user()->id;
                $his->save();

                $users = Suivi_amelioration::join('ameliorations', 'suivi_ameliorations.amelioration_id', 'ameliorations.id')
                            ->join('actions', 'suivi_ameliorations.action_id', 'actions.id')
                            ->join('postes', 'actions.poste_id', 'postes.id')
                            ->join('users', 'users.poste_id', 'postes.id')
                            ->where('ameliorations.id', $id)
                            ->select('users.email as email')
                            ->get();

                foreach ($users as $user) {

                    $mail = new PHPMailer(true);
                    $mail->isHTML(true);
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'coherencemail01@gmail.com';
                    $mail->Password = 'kiur ejgn ijqt kxam';
                    $mail->SMTPSecure = 'ssl';
                    $mail->Port = 465;
                    // Destinataire, sujet et contenu de l'email
                    $mail->setFrom('coherencemail01@gmail.com', 'Coherence');
                    $mail->addAddress($user->email);
                    $mail->Subject = 'ALERT !';
                    $mail->Body = 'Nouvelle Action Préventive';
                    // Envoi de l'email
                    $mail->send();
                }

                event(new NotificationAm2());
                event(new NotificationAm3());

                return redirect()
                    ->back()
                    ->with('success', 'Validation éffectuée.');
            }

        }

        return redirect()
            ->back()
            ->with('error', 'Validation a échoué.');

    }

}
