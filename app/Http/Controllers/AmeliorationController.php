<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Events\NotificationAcorrective;
use App\Events\NotificationAmnew;

use App\Models\Processuse;
use App\Models\Objectif;
use App\Models\Resva;
use App\Models\Risque;
use App\Models\Cause;
use App\Models\Rejet;
use App\Models\Action;
use App\Models\Suivi_action;
use App\Models\Suivi_amelioration;
use App\Models\Poste;
use App\Models\User;
use App\Models\Amelioration;
use App\Models\Causetrouver;
use App\Models\Risquetrouver;
use App\Models\Historique_action;
use App\Models\Color_para;
use App\Models\Color_interval;

use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class AmeliorationController extends Controller
{
   public function index()
   {
        $risques = Risque::join('postes', 'risques.poste_id', '=', 'postes.id')
                ->where('risques.statut', '=', 'valider' )
                ->where('risques.page', '=', 'risk' )
                ->select('risques.*','postes.nom as validateur')
                ->get();

        $causesData = [];
        $actionsData = [];

        foreach($risques as $risque)
        {
            $processus = Processuse::where('id', $risque->processus_id)->first();
            $risque->nom_processus = $processus->nom;

            $actions = Action::join('postes', 'actions.poste_id', '=', 'postes.id')
                ->where('actions.risque_id', $risque->id)
                ->select('actions.*','postes.nom as responsable')
                ->get();

            $actionsData[$risque->id] = [];
            
            foreach($actions as $action)
            {
                if ($action->type === 'preventive') {

                    $actionsData[$risque->id][] = [
                        'action' => $action->action,
                        'type' => $action->type,
                        'responsable' => $action->responsable,
                    ];
                } else if($action->type === 'corrective') {

                    $actionsData[$risque->id][] = [
                        'action' => $action->action,
                        'type' => $action->type,
                        'responsable' => $action->responsable,
                    ];
                }
               
            }

            $causes = Cause::where('causes.risque_id', $risque->id)->get();
            $risque->nbre_cause = count($causes);
            
            $causesData[$risque->id] = [];
            
            foreach($causes as $cause)
            {
                $causesData[$risque->id][] = [
                    'cause' => $cause->nom,
                    'dispositif' => $cause->dispositif,
                ];
            }
        }


        $causes_selects = Cause::join('risques', 'causes.risque_id', '=', 'risques.id')
                                ->where('risques.statut', '=', 'valider' )
                                ->where('risques.page', '=', 'risk' )
                                ->select('causes.*')
                                ->get();

        $causesData2 = [];
        $actionsData2 = [];

        $Suivi_action2 = null;
        $caus2 = null;

        foreach($causes_selects as $causes_select)
        {

            $risques2 = Risque::join('postes', 'risques.poste_id', '=', 'postes.id')
                    ->where('risques.id', $causes_select->risque_id )
                    ->where('risques.statut', '=', 'valider' )
                    ->select('risques.*','postes.nom as validateur')
                    ->first();
            if($risques2) {

                $causes_select->nom_risque = $risques2->nom;
                $causes_select->vraisemblence = $risques2->vraisemblence;
                $causes_select->gravite = $risques2->gravite;
                $causes_select->evaluation = $risques2->evaluation;
                $causes_select->cout = $risques2->cout;
                $causes_select->vraisemblence_residuel = $risques2->vraisemblence_residuel;
                $causes_select->gravite_residuel = $risques2->gravite_residuel;
                $causes_select->evaluation_residuel = $risques2->evaluation_residuel;
                $causes_select->cout_residuel = $risques2->cout_residuel;
                $causes_select->statut = $risques2->statut;
                $causes_select->date_validation = $risques2->date_validation;
                $causes_select->traitement = $risques2->traitement;
                $causes_select->validateur = $risques2->validateur;

                $processus2 = Processuse::where('id', $risques2->processus_id)->first();
                if($processus2) {
                    $causes_select->nom_processus = $processus2->nom;
                }
            }

            $causes2 = Cause::where('causes.risque_id', $causes_select->risque_id)->get();
            if($causes2) {

                $causesData2[$causes_select->risque_id] = [];

                foreach($causes2 as $caus2)
                {
                   $causesData2[$caus2->risque_id][] = [
                        'cause' => $caus2->nom,
                        'dispositif' => $caus2->dispositif,
                    ];
                }
            }

            $actions2 = Action::join('postes', 'actions.poste_id', '=', 'postes.id')
                  ->where('actions.risque_id', $causes_select->risque_id)
                  ->select('actions.*','postes.nom as responsable')
                  ->get();

            if($actions2) {

                $actionsData2[$causes_select->risque_id] = [];

                foreach($actions2 as $action2)
                {
                    if ($action2->type === 'preventive') {

                        $actionsData2[$causes_select->risque_id][] = [
                            'action' => $action2->action,
                            'type' => $action2->type,
                            'responsable' => $action2->responsable,
                        ];
                    } else if($action2->type === 'corrective') {

                        $actionsData2[$causes_select->risque_id][] = [
                            'action' => $action2->action,
                            'responsable' => $action2->responsable,
                            'type' => $action2->type,
                        ];
                    }
                }
            }

        }

        $postes = Poste::join('users', 'users.poste_id', 'postes.id')
                        ->select('postes.*') // Sélectionne les colonnes de la table 'postes'
                        ->distinct() // Rend les résultats uniques
                        ->get();
        $processuss = Processuse::all();

        $color_para = Color_para::where('nbre0', '=', '0')->first();
        $color_intervals = Color_interval::orderBy('nbre1', 'asc')->get();
        $color_interval_nbre = count($color_intervals);

        return view('add.ficheamelioration',[
            'risques' => $risques, 
            'causesData' => $causesData, 
            'actionsData' => $actionsData, 
            'causes_selects' => $causes_selects, 
            'Suivi_action2' => $Suivi_action2, 
            'caus2' => $caus2, 'causesData2' => $causesData2, 
            'actionsData2' => $actionsData2, 
            'postes' => $postes, 
            'processuss' => $processuss,
            'color_para' => $color_para,
            'color_intervals' => $color_intervals,
            'color_interval_nbre' => $color_interval_nbre,
        ]);
   }

    public function get_cause_info($id)
    {
        $cause = Cause::find($id);
        $risque = Risque::find($cause->risque_id);
        $actions = Action::join('postes', 'actions.poste_id', '=', 'postes.id')
                      ->where('actions.risque_id', $risque->id)
                      ->where('actions.type', 'corrective')
                      ->select('actions.*', 'postes.nom as responsable')
                      ->get();

        $nbre = count($actions);

        foreach ($actions as $action) {

            $action->risque = $risque->nom;
            $action->risque_id = $risque->id;

            $processus = Processuse::find($risque->processus_id);
            $action->processus = $processus->nom;
            $action->processus_id = $processus->id;

            $action->trouve="cause";
            $action->trouve_id=$cause->id;

        }

        return response()->json([
            'actions' => $actions, 'nbre' => $nbre
        ]);
    }

    public function get_risque_info($id)
    {
        $risque = Risque::find($id);
        $actions = Action::join('postes', 'actions.poste_id', '=', 'postes.id')
                      ->where('actions.risque_id', $risque->id)
                      ->where('actions.type', 'corrective')
                      ->select('actions.*', 'postes.nom as responsable')
                      ->get();

        $nbre = count($actions);

        foreach ($actions as $action) {

            $action->risque = $risque->nom;
            $action->risque_id = $risque->id;

            $processus = Processuse::find($risque->processus_id);
            $action->processus = $processus->nom;
            $action->processus_id = $processus->id;

            $action->trouve="risque";
            $action->trouve_id=$risque->id;

        }

        return response()->json([
            'actions' => $actions, 'nbre' => $nbre
        ]);
    }

    public function index_add(Request $request)
    {
        $type = $request->input('type');

        $date_fichee = $request->input('date_fiche');
        $dateCarbon = Carbon::createFromFormat('Y-m-d', $date_fichee);
        $date_fiche = $dateCarbon->format('Y-m-d');

        $lieu = $request->input('lieu');
        $detecteur = $request->input('detecteur');
        $non_conformite = $request->input('non_conformite');
        $consequence = $request->input('consequence');
        $cause = $request->input('cause');
        $choix_select = $request->input('choix_select');

        $trouve = $request->input('trouve');
        $trouve_id = $request->input('trouve_id');

        $nature = $request->input('nature');
        $processus_id = $request->input('processus_id');
        $risque = $request->input('risque');
        $resume = $request->input('resume');
        $action = $request->input('action');
        $action_id = $request->input('action_id');
        $poste_id = $request->input('poste_id');
        $date_action = $request->input('date_action');
        $commentaire = $request->input('commentaire');

        $choix_alert_alert = $request->input('choix_alert_alert');
        $choix_alert_email = $request->input('choix_alert_email');
        $choix_alert_sms = $request->input('choix_alert_sms');

        $am = new Amelioration();
        $am->type = $type;
        $am->date_fiche = $date_fiche;
        $am->lieu =$lieu;
        $am->detecteur = $detecteur;
        $am->non_conformite = $non_conformite;
        $am->consequence = $consequence;
        $am->cause = $cause;
        $am->choix_select = $choix_select;
        $am->statut = 'soumis';
        $am->save();

        foreach ($nature as $index => $valeur) {

            $risque_id = $risque[$index];

            if ($nature[$index] === 'accepte') {

                $suivic = new Suivi_amelioration();
                $suivic->delai = $date_action[$index];
                $suivic->type = 'action';
                $suivic->nature = $nature[$index];
                $suivic->trouve = $trouve[$index];
                $suivic->statut = 'non-realiser';
                $suivic->amelioration_id = $am->id;
                $suivic->action_id = $action_id[$index];
                $suivic->processus_id = $processus_id[$index];
                $suivic->risque_id = $risque[$index];
                if ($trouve[$index] === 'cause') {$suivic->cause_id = $trouve_id[$index];}
                if ($trouve[$index] === 'risque') {$suivic->risque_id = $trouve_id[$index];}
                $suivic->commentaire_am = $commentaire[$index];
                $suivic->save();

            }

            if ($nature[$index] === 'non-accepte') {

                $actionn = new Action();
                $actionn->action = $action[$index];
                $actionn->page = 'am';
                $actionn->type = 'corrective';
                $actionn->poste_id = $poste_id[$index];
                $actionn->risque_id = $risque[$index];
                $actionn->save();

                $suivic = new Suivi_amelioration();
                $suivic->delai = $date_action[$index];
                $suivic->type = 'action_am';
                $suivic->nature = $nature[$index];
                $suivic->trouve = $trouve[$index];
                $suivic->statut = 'non-realiser';
                $suivic->amelioration_id = $am->id;
                $suivic->action_id = $actionn->id;
                $suivic->risque_id = $risque[$index];
                $suivic->processus_id = $processus_id[$index];
                if ($trouve[$index] === 'cause') {$suivic->cause_id = $trouve_id[$index];}
                if ($trouve[$index] === 'risque') {$suivic->risque_id = $trouve_id[$index];}
                $suivic->commentaire_am = $commentaire[$index];
                $suivic->save();

            }

            if ($nature[$index] === 'new') {

                $risquee = new Risque();
                $risquee->nom = $risque[$index];
                $risquee->page = 'am';
                $risquee->processus_id = $processus_id[$index];
                $risquee->poste_id = $poste_id[$index];
                $risquee->save();

                $cause = new Cause();
                $cause->nom = $resume[$index];
                $cause->page = 'am';
                $cause->risque_id = $risquee->id;
                $cause->save();

                $actionn = new Action();
                $actionn->action = $action[$index];
                $actionn->page = 'am';
                $actionn->type = 'corrective';
                $actionn->poste_id = $poste_id[$index];
                $actionn->risque_id = $risquee->id;
                $actionn->save();

                $suivic = new Suivi_amelioration();
                $suivic->delai = $date_action[$index];
                $suivic->type = 'action_am';
                $suivic->nature = $nature[$index];
                $suivic->trouve = 'new_risque';
                $suivic->statut = 'non-realiser';
                $suivic->amelioration_id = $am->id;
                $suivic->action_id = $actionn->id;
                $suivic->risque_id = $risquee->id;
                $suivic->cause_id = $cause->id;
                $suivic->processus_id = $processus_id[$index];
                $suivic->commentaire_am = $commentaire[$index];
                $suivic->save();
            }

            if ($choix_alert_email === 'email') {

                $user = User::join('postes', 'users.poste_id', 'postes.id')
                            ->where('postes.id', $poste_id[$index])
                            ->select('users.*')
                            ->first();
                if ($user) {

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
                    $mail->Body = 'Nouvelle(s) Action(s) Corrective(s)';
                    // Envoi de l'email
                    $mail->send();
                 }

            }

        }

        if ($am) {

            if ($choix_alert_alert === 'alert') {

                event(new NotificationAcorrective());

            }

            event(new NotificationAmnew());

            $his = new Historique_action();
            $his->nom_formulaire = "Nouvelle fiche d'amélioration";
            $his->nom_action = 'Ajouter';
            $his->user_id = Auth::user()->id;
            $his->save();

            return back()
                ->with('success', 'Enregistrement éffectuée.');

        } else {
            return back()
                ->with('error', 'Enregistrement non éffectuée.');
        }
    }

    public function index_liste()
    {
        $ams = Amelioration::all();

        $actionsData = [];

        foreach ($ams as $am) {
            $am->nbre_action = Suivi_amelioration::where('amelioration_id', '=', $am->id)->count();

            $suivi = Suivi_amelioration::where('amelioration_id', '=', $am->id)->get();
            $actionsData[$am->id] = [];
            foreach ($suivi as $suivis) {

                $action = Suivi_amelioration::join('actions', 'suivi_ameliorations.action_id', 'actions.id')
                                            ->join('postes', 'actions.poste_id', 'postes.id')
                                            ->join('risques', 'actions.risque_id', 'risques.id')
                                            ->join('processuses', 'risques.processus_id', 'processuses.id')
                                            ->where('actions.id', '=', $suivis->action_id)
                                            ->select('suivi_ameliorations.*', 'actions.action as action', 'postes.nom as poste', 'processuses.nom as processus', 'risques.nom as risque')
                                            ->first();

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

        return view('liste.amelioration', ['ams' => $ams, 'actionsData' => $actionsData ]);
    }


}
