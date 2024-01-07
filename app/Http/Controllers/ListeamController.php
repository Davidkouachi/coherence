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
use App\Events\NotificationAmvalider;
use App\Events\NotificationAmcorrective;
use App\Events\NotificationAmrejet;

use App\Models\Processuse;
use App\Models\Amelioration;
use App\Models\Objectif;
use App\Models\Risque;
use App\Models\Cause;
use App\Models\Rejet;
use App\Models\Rejet_am;
use App\Models\Action;
use App\Models\Suivi_action;
use App\Models\Pdf_file;
use App\Models\Pdf_file_processus;
use App\Models\User;
use App\Models\Historique_action;
use App\Models\Poste;
use App\Models\Suivi_amelioration;
use App\Models\Color_para;
use App\Models\Color_interval;

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

        return view('tableau.valideam', ['ams' => $ams, 'actionsData' => $actionsData ]);
    }

    public function index_amup()
    {
        $ams = Amelioration::where('statut', 'non-valider')
                           ->orWhere('statut', 'modif')
                           ->get();

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

        return view('traitement.amup', ['ams' => $ams, 'actionsData' => $actionsData ]);
    }

    public function index_amup2(Request $request)
    {
        $am = Amelioration::where('id', '=', $request->id)->first();

        $actionsDatam = [];

        if ($am) {

            $suivi = Suivi_amelioration::where('amelioration_id', '=', $am->id)->get();

            $actionsDatam[$am->id] = [];

            foreach ($suivi as $suivis) {

                    $action= null;

                    if ($suivis->trouve === 'cause') {

                        $action = Action::join('postes', 'actions.poste_id', 'postes.id')
                                    ->join('risques', 'actions.risque_id', 'risques.id')
                                    ->join('causes', 'causes.risque_id', 'risques.id')
                                    ->join('processuses', 'risques.processus_id', 'processuses.id')
                                    ->where('actions.id', '=', $suivis->action_id)
                                    ->select('actions.action as action', 'postes.id as poste_id', 'processuses.id as processus_id', 'risques.nom as risque', 'causes.nom as cause')
                                    ->first();

                        if ($action) {
                            $actionsDatam[$am->id][] = [
                                'action' => $action->action,
                                'poste_id' => $action->poste_id,
                                'delai' => $suivis->delai,
                                'trouve' => $suivis->trouve,
                                'processus_id' => $action->processus_id,
                                'risque' => $action->risque,
                                'cause' => $action->cause,
                                'commentaire_am' => $suivis->commentaire_am,
                                'suivi_id' => $suivis->id,
                            ];
                        }

                    } else if ($suivis->trouve === 'risque') {

                        $action = Action::join('postes', 'actions.poste_id', 'postes.id')
                                    ->join('risques', 'actions.risque_id', 'risques.id')
                                    ->join('processuses', 'risques.processus_id', 'processuses.id')
                                    ->where('actions.id', '=', $suivis->action_id)
                                    ->select('actions.action as action', 'postes.id as poste_id', 'processuses.id as processus_id', 'risques.nom as risque')
                                    ->first();

                        if ($action) {
                            $actionsDatam[$am->id][] = [
                                'action' => $action->action,
                                'poste_id' => $action->poste_id,
                                'delai' => $suivis->delai,
                                'trouve' => $suivis->trouve,
                                'processus_id' => $action->processus_id,
                                'risque' => $action->risque,
                                'commentaire_am' => $suivis->commentaire_am,
                                'suivi_id' => $suivis->id,
                            ];
                        }

                    } else if ($suivis->trouve === 'new_risque') {

                        $action = Action::join('postes', 'actions.poste_id', 'postes.id')
                                    ->join('risques', 'actions.risque_id', 'risques.id')
                                    ->join('causes', 'causes.risque_id', 'risques.id')
                                    ->join('processuses', 'risques.processus_id', 'processuses.id')
                                    ->where('actions.id', '=', $suivis->action_id)
                                    ->select('actions.action as action', 'postes.id as poste_id', 'processuses.id as processus_id', 'risques.nom as risque', 'causes.nom as cause')
                                    ->first();

                        if ($action) {
                            $actionsDatam[$am->id][] = [
                                'action' => $action->action,
                                'poste_id' => $action->poste_id,
                                'delai' => $suivis->delai,
                                'trouve' => $suivis->trouve,
                                'processus_id' => $action->processus_id,
                                'risque' => $action->risque,
                                'cause' => $action->cause,
                                'commentaire_am' => $suivis->commentaire_am,
                                'suivi_id' => $suivis->id,
                            ];
                        }

                    }

            }
        } else {

            return back()->with('error', 'Réclamation non trouvée');
        }

        $postes = Poste::join('users', 'users.poste_id', 'postes.id')
                        ->select('postes.*') // Sélectionne les colonnes de la table 'postes'
                        ->distinct() // Rend les résultats uniques
                        ->get();
        $processuss = Processuse::all();

        return view('traitement.amup2', ['postes' => $postes, 'processuss' => $processuss, 'actionsDatam' => $actionsDatam, 'am' => $am]);
    }

    public function index_amup_add(Request $request)
    {
        $am_id = $request->id;

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
        $color_interval_nbre = Color_interval::all()->count();

        return view('traitement.amup_add', 
            ['risques' => $risques, 'causesData' => $causesData, 'actionsData' => $actionsData, 
            'causes_selects' => $causes_selects, 'Suivi_action2' => $Suivi_action2, 'caus2' => $caus2, 'causesData2' => $causesData2, 'actionsData2' => $actionsData2, 'postes' => $postes, 'processuss' => $processuss, 'am_id' => $am_id,'color_para' => $color_para,'color_interval_nbre' => $color_interval_nbre,]);
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

                event(new NotificationAmvalider());
                event(new NotificationAmcorrective());

                return redirect()
                    ->back()
                    ->with('success', 'Validation éffectuée.');
            }

        }

        return redirect()
            ->back()
            ->with('error', 'Validation a échoué.');
    }

    public function am_rejet(Request $request)
    {
        $rejet = Rejet_am::where('amelioration_id', $request->input('amelioration_id'))->first();

        if ($rejet)
        {
            $rejet->motif = $request->input('motif');
            $rejet->update();

        } else {

            $rejet = new Rejet_am();
            $rejet->motif = $request->input('motif');
            $rejet->amelioration_id = $request->input('amelioration_id');
            $rejet->save();

        }

        if ($rejet)
        {
            $valide = Amelioration::where('id', $request->input('amelioration_id'))->first();

            if ($valide)
            {

                $valide->date_validation = now()->format('Y-m-d\TH:i');
                $valide->statut = 'non-valider';
                $valide->update();

                if ($valide) {

                    $his = new Historique_action();
                    $his->nom_formulaire = 'Validation fiche amelioration';
                    $his->nom_action = 'Rejet';
                    $his->user_id = Auth::user()->id;
                    $his->save();

                    event(new NotificationAmrejet());

                    /*$users = Suivi_amelioration::join('ameliorations', 'suivi_ameliorations.amelioration_id', 'ameliorations.id')
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
                    }*/


                    return redirect()
                        ->back()
                        ->with('success', 'Rejet éffectuée.');
                }

            }

        }

        return redirect()
            ->back()
            ->with('error', 'Echec du Rejet.');
    }

}
