<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Events\NotificationAcorrective;

use App\Models\Processuse;
use App\Models\Objectif;
use App\Models\Resva;
use App\Models\Risque;
use App\Models\Risque_am;
use App\Models\Cause;
use App\Models\Cause_am;
use App\Models\Rejet;
use App\Models\Action;
use App\Models\Action_am;
use App\Models\Suivi_action;
use App\Models\Suivi_amelioration;
use App\Models\Poste;
use App\Models\User;
use App\Models\Amelioration;
use App\Models\Causetrouver;
use App\Models\Risquetrouver;

use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class AmeliorationController extends Controller
{
   public function index()
   {
        $risques = Risque::join('postes', 'risques.poste_id', '=', 'postes.id')
                ->where('risques.statut', '!=', 'amelioration' )
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


        $causes_selects = Cause::all();

        $causesData2 = [];
        $actionsData2 = [];

        $Suivi_action2 = null;
        $caus2 = null;

        foreach($causes_selects as $causes_select)
        {

            $risques2 = Risque::join('postes', 'risques.poste_id', '=', 'postes.id')
                    ->where('risques.id', $causes_select->risque_id )
                    ->where('risques.statut', '!=', 'amelioration' )
                    ->select('risques.*','postes.nom as validateur')
                    ->first();

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
            $causes_select->nom_processus = $processus2->nom;

            $causes2 = Cause::where('causes.risque_id', $causes_select->risque_id)->get();

            $causesData2[$causes_select->risque_id] = [];

            foreach($causes2 as $caus2)
            {
               $causesData2[$caus2->risque_id][] = [
                    'cause' => $caus2->nom,
                    'dispositif' => $caus2->dispositif,
                ];
            }

            $actions2 = Action::join('postes', 'actions.poste_id', '=', 'postes.id')
                  ->where('actions.risque_id', $causes_select->risque_id)
                  ->select('actions.*','postes.nom as responsable')
                  ->get();

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

        $postes = Poste::join('users', 'users.poste_id', 'postes.id')
                        ->select('postes.*') // Sélectionne les colonnes de la table 'postes'
                        ->distinct() // Rend les résultats uniques
                        ->get();
        $processuss = Processuse::all();

        return view('add.ficheamelioration', 
            ['risques' => $risques, 'causesData' => $causesData, 'actionsData' => $actionsData, 
            'causes_selects' => $causes_selects, 'Suivi_action2' => $Suivi_action2, 'caus2' => $caus2, 'causesData2' => $causesData2, 'actionsData2' => $actionsData2, 'postes' => $postes, 'processuss' => $processuss]);
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
            'actions' => $actions
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
            'actions' => $actions
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

        foreach ($nature as $index => $valeur) {

            $risque_id = $risque[$index];

            $am = new Amelioration();
            $am->type = $type;
            $am->date_fiche = $date_fiche;
            $am->lieu =$lieu;
            $am->detecteur = $detecteur;
            $am->non_conformite = $non_conformite;
            $am->consequence = $consequence;
            $am->cause = $cause;
            $am->choix_select = $choix_select;
            //$am->nature = $nature[$index];
            $am->save();

            if ($nature[$index] === 'accepte') {

                $suivic = new Suivi_amelioration();
                $suivic->delai = $date_action[$index];
                $suivic->type = 'accepte';
                $suivic->nature = $nature[$index];
                $suivic->statut = 'non-realiser';
                $suivic->amelioration_id = $am->id;
                $suivic->action_id = $action_id[$index];
                $suivic->processus_id = $processus_id[$index];
                $suivic->risque_id = $risque[$index];
                $suivic->commentaire_am = $commentaire[$index];
                $suivic->save();

                if ($trouve[$index] === 'cause') {

                    $cause = new Causetrouver();
                    $cause->amelioration_id = $am->id;
                    $cause->cause_id = $trouve_id[$index];
                    $cause->save();

                } else if ($trouve[$index] === 'risque') {

                    $risque = new Risquetrouver();
                    $risque->amelioration_id = $am->id;
                    $risque->risque_id = $trouve_id[$index];
                    $risque->save();

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
                        $mail->Subject = 'Nouveau Action';
                        $mail->Body = 'ALERT ! <br><br>'.'<br>'
                            . 'Nouvelle Action Corrective à réaliser';
                        // Envoi de l'email
                        $mail->send();
                    }

                }

                if ($choix_alert_sms === 'sms') {

                }

            }

            if ($nature[$index] === 'non-accepte') {

                $actionn = new Action_am();
                $actionn->action = $action[$index];
                $actionn->poste_id = $poste_id[$index];
                $actionn->risque_id = $risque[$index];
                $actionn->save();

                $suivic = new Suivi_amelioration();
                $suivic->delai = $date_action[$index];
                $suivic->type = 'non-accepte';
                $suivic->nature = $nature[$index];
                $suivic->statut = 'non-realiser';
                $suivic->amelioration_id = $am->id;
                $suivic->action_id = $actionn->id;
                $suivic->risque_id = $risque[$index];
                $suivic->processus_id = $processus_id[$index];
                $suivic->commentaire_am = $commentaire[$index];
                $suivic->save();

                if ($trouve[$index] === 'cause') {

                    $cause = new Causetrouver();
                    $cause->amelioration_id = $am->id;
                    $cause->cause_id = $trouve_id[$index];
                    $cause->save();

                } else if ($trouve[$index] === 'risque') {

                    $risque = new Risquetrouver();
                    $risque->amelioration_id = $am->id;
                    $risque->risque_id = $trouve_id[$index];
                    $risque->save();

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
                        $mail->Subject = 'Nouveau Action';
                        $mail->Body = 'ALERT ! <br><br>'.'<br>'
                            . 'Nouvelle Action Corrective à réaliser';
                        // Envoi de l'email
                        $mail->send();
                    }

                }

                if ($choix_alert_sms === 'sms') {

                }

            }

            if ($nature[$index] === 'new') {

                $risquee = new Risque_am();
                $risquee->nom = $risque[$index];
                $risquee->processus_id = $processus_id[$index];
                $risquee->poste_id = $poste_id[$index];
                $risquee->save();

                $cause = new Cause_am();
                $cause->nom = $resume[$index];
                $cause->risque_id = $risquee->id;
                $cause->save();

                $actionn = new Action_am();
                $actionn->action = $action[$index];
                $actionn->poste_id = $poste_id[$index];
                $actionn->risque_id_am = $risquee->id;
                $actionn->save();

                $suivic = new Suivi_amelioration();
                $suivic->delai = $date_action[$index];
                $suivic->type = 'new';
                $suivic->nature = $nature[$index];
                $suivic->statut = 'non-realiser';
                $suivic->amelioration_id = $am->id;
                $suivic->action_id = $actionn->id;
                $suivic->risque_id_am = $risquee->id;
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
                        $mail->Subject = 'Nouveau Action';
                        $mail->Body = 'ALERT ! <br><br>'.'<br>'
                            . 'Nouvelle Action Corrective à réaliser';
                        // Envoi de l'email
                        $mail->send();
                    }

                }

                if ($choix_alert_sms === 'sms') {

                }

        }

        if ($am) {

                if ($choix_alert_alert === 'alert') {

                    event(new NotificationAcorrective());

                }

            return redirect()
                ->back()
                ->with('ajouter', 'Enregistrement éffectuée.');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Enregistrement non éffectuée.');
        }


    }

    public function index_liste()
    {

        return view('liste.amelioration');
    }

}
