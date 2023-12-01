<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
use App\Models\User;
use App\Models\Historique_action;
use App\Models\Amelioration;

use App\Events\NotificationApreventive;

use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class SuiviactionController extends Controller
{
    public function index_suiviaction()
    {
        $actions = Action::join('postes', 'actions.poste_id', '=', 'postes.id')
                ->join('risques', 'actions.risque_id', '=', 'risques.id')
                ->join('processuses', 'risques.processus_id', '=', 'processuses.id')
                ->join('suivi_actions', 'actions.id', '=', 'suivi_actions.action_id')
                ->where('risques.statut', 'valider')
                ->where('suivi_actions.statut', 'non-realiser')
                ->where('actions.type', 'preventive')
                ->select('actions.*','postes.nom as responsable','risques.nom as risque','processuses.nom as processus')
                ->get();

        return view('traitement.suiviaction',  ['actions' => $actions]);
    }

    public function index_suiviactionc()
    {
        $ams = Amelioration::join('suivi_ameliorations', 'ameliorations.id', '=', 'suivi_ameliorations.amelioration_id')
                            ->where('suivi_ameliorations.statut', 'non-realiser')
                            ->select('ameliorations.*','suivi_ameliorations.delai as delai', 'suivi_ameliorations.date_action as date_ation', 'suivi_ameliorations.nature as nature', 'suivi_ameliorations.action_id as action_id')
                            ->get();
        foreach ($ams as $am) {

            if ($am->nature === 'new') {

                $actions = Action_am::join('postes', 'action_ams.poste_id', '=', 'postes.id')
                ->join('risque_ams', 'action_ams.risque_id_am', '=', 'risque_ams.id')
                ->join('processuses', 'risque_ams.processus_id', '=', 'processuses.id')
                ->where('action_ams.id', $am->action_id)
                ->select('action_ams.*','postes.nom as responsable','risque_ams.nom as risque','processuses.nom as processus')
                ->first();

                if ($actions) {
                    $am->responsable = $actions->responsable;
                    $am->risque = $actions->risque;
                    $am->processus = $actions->processus;
                    $am->action = $actions->action;
                }

            } else if ($am->nature === 'accepte') {

                $actions = Action::join('postes', 'actions.poste_id', '=', 'postes.id')
                ->join('risques', 'actions.risque_id', '=', 'risques.id')
                ->join('processuses', 'risques.processus_id', '=', 'processuses.id')
                ->where('actions.id', $am->action_id)
                ->select('actions.*','postes.nom as responsable','risques.nom as risque','processuses.nom as processus')
                ->first();

                if ($actions) {
                    $am->responsable = $actions->responsable;
                    $am->risque = $actions->risque;
                    $am->processus = $actions->processus;
                    $am->action = $actions->action;
                }
            } else if ($am->nature === 'non-accepte') {

                $actions = Action_am::join('postes', 'action_ams.poste_id', '=', 'postes.id')
                ->join('risques', 'action_ams.risque_id', '=', 'risques.id')
                ->join('processuses', 'risques.processus_id', '=', 'processuses.id')
                ->where('action_ams.id', $am->action_id)
                ->select('action_ams.*','postes.nom as responsable','risques.nom as risque','processuses.nom as processus')
                ->first();

                if ($actions) {
                    $am->responsable = $actions->responsable;
                    $am->risque = $actions->risque;
                    $am->processus = $actions->processus;
                    $am->action = $actions->action;
                }

            }

        }

        return view('traitement.suiviactionc',  ['ams' => $ams]);
    }

    public function add_suivi_action(Request $request, $id)
    {
        $suivi = Suivi_action::where('action_id', $id)->first();
        if ($suivi)
        {
            $suivi->efficacite = $request->input('efficacite');
            $suivi->commentaire = $request->input('commentaire');
            $suivi->date_action = $request->input('date_action');
            $suivi->statut = 'realiser';
            $suivi->date_suivi = now()->format('Y-m-d\TH:i');
            $suivi->update();

            if ($suivi)
            {

                $his = new Historique_action();
                $his->nom_formulaire = 'Tableau du suivi des actions';
                $his->nom_action = 'Suivi';
                $his->user_id = Auth::user()->id;
                $his->save();
            }

        }

        return redirect()
            ->back()
            ->with('valider', 'Suivi éffectué.');
    }

    public function add_suivi_actionc(Request $request, $id)
    {
        $suivi = Suivi_amelioration::where('amelioration_id', $id)->first();
        if ($suivi)
        {
            $suivi->efficacite = $request->input('efficacite');
            $suivi->commentaire = $request->input('commentaire');
            $suivi->date_action = $request->input('date_action');
            $suivi->date_suivi = now()->format('Y-m-d\TH:i');
            $suivi->statut = 'realiser';
            $suivi->update();

            if ($suivi)
            {

                $his = new Historique_action();
                $his->nom_formulaire = 'Tableau du suivi des actions';
                $his->nom_action = 'Suivi';
                $his->user_id = Auth::user()->id;
                $his->save();
            }

        }

        return redirect()
            ->back()
            ->with('valider', 'Suivi éffectué.');
    }

    public function index_historique()
    {

        $historiques = Historique_action::join('users', 'historique_actions.user_id', '=', 'users.id')
                ->join('postes', 'users.poste_id', '=', 'postes.id')
                ->orderBy('historique_actions.created_at', 'desc')
                ->select('historique_actions.*', 'postes.nom as poste', 'users.name as nom', 'users.matricule as matricule')
                ->get();

       return view('historique.historique', ['historiques' => $historiques]);
    }

    public function index_historique_profil()
    {
        $historiques = Historique_action::join('users', 'historique_actions.user_id', '=', 'users.id')
                ->join('poste', 'users.poste_id', '=', 'postes.id')
                ->orderBy('historique_actions.created_at', 'desc')
                ->where('historique_actions.user_id', Auth::user()->id)
                ->select('historique_actions.*', 'postes.nom as poste', 'users.name as nom', 'users.matricule as matricule')
                ->get();

       return view('historique.historique_profil', ['historiques' => $historiques]);
    }

}
