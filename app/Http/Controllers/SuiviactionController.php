<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Processuse;
use App\Models\Objectif;
use App\Models\Resva;
use App\Models\Risque;
use App\Models\Cause;
use App\Models\Rejet;
use App\Models\Action;
use App\Models\Suivi_action;
use App\Models\User;
use App\Models\Historique_action;

use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class SuiviactionController extends Controller
{
    public function index_suiviaction()
    {
        $actions = Action::join('users', 'actions.responsable_id', '=', 'users.id')
                ->join('risques', 'actions.risque_id', '=', 'risques.id')
                ->join('processuses', 'risques.processus_id', '=', 'processuses.id')
                ->where('risques.statut', 'valider')
                ->where('actions.statut', 'non-realiser')
                ->select('actions.*','users.poste as responsable','risques.nom as risque','processuses.nom as processus')
                ->get();

        return view('traitement.suiviaction',  ['actions' => $actions]);
    }

    public function add_suivi_action(Request $request, $id)
    {
        $suivi = Suivi_action::where('action_id', $id)->first();
        if ($suivi)
        {
            $suivi->efficacite = $request->input('efficacite');
            $suivi->commentaire = $request->input('commentaire');
            $suivi->date_action = $request->input('date_action');
            $suivi->date_suivi = now()->format('Y-m-d\TH:i');
            $suivi->update();

            $action = Action::where('id', $id)->first();
            if($action)
            {
                $action->statut = 'realiser';
                $action->update();

                if ($action || $suivi)
                {
                    $his = new Historique_action();
                    $his->nom_formulaire = 'Tableau du suivi des actions';
                    $his->nom_action = 'Suivi';
                    $his->user_id = Auth::user()->id;
                    $his->save();
                }
            }

        }

        return redirect()
            ->back()
            ->with('valider', 'Suivi éffectué.');
    }

    public function index_historique()
    {

        $historiques = Historique_action::join('users', 'historique_actions.user_id', '=', 'users.id')
                ->orderBy('historique_actions.created_at', 'desc')
                ->select('historique_actions.*', 'users.poste as poste', 'users.name as nom', 'users.matricule as matricule')
                ->get();

       return view('historique.historique', ['historiques' => $historiques]);
    }

    public function index_historique_profil()
    {
        $historiques = Historique_action::join('users', 'historique_actions.user_id', '=', 'users.id')
                ->orderBy('historique_actions.created_at', 'desc')
                ->where('historique_actions.user_id', Auth::user()->id)
                ->select('historique_actions.*', 'users.poste as poste', 'users.name as nom', 'users.matricule as matricule')
                ->get();

       return view('historique.historique_profil', ['historiques' => $historiques]);
    }

}
