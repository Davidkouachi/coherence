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
                ->select('actions.*','postes.nom as responsable','risques.nom as risque' ,'risques.date_validation as date_validation' ,'processuses.nom as processus','risques.date_validation as date_validation')
                ->get();

        return view('traitement.suiviaction',  ['actions' => $actions]);
    }

    public function index_suiviactionc()
    {
        $ams = Suivi_amelioration::join('ameliorations', 'suivi_ameliorations.amelioration_id', '=', 'ameliorations.id')
                            ->join('actions', 'suivi_ameliorations.action_id', '=', 'actions.id')
                            ->join('postes', 'actions.poste_id', '=', 'postes.id')
                            ->join('risques', 'actions.risque_id', '=', 'risques.id')
                            ->join('processuses', 'risques.processus_id', '=', 'processuses.id')
                            ->where('suivi_ameliorations.statut', 'non-realiser')
                            ->where('ameliorations.statut', 'valider')
                            ->select('Suivi_ameliorations.*', 'postes.nom as responsable', 'risques.nom as risque', 'processuses.nom as processus', 'ameliorations.type as type', 'ameliorations.date_validation as date_validation', 'ameliorations.non_conformite as non_conformite', 'actions.action as action',)
                            ->get();

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
                $his->nom_formulaire = 'Suivi des actions preventive';
                $his->nom_action = 'Suivi effectué';
                $his->user_id = Auth::user()->id;
                $his->save();

                return back()
                        ->with('success', 'Suivi éffectué.');
            }

        }

        return back()
            ->with('error', 'Suivi non éffectuée.');
    }

    public function add_suivi_actionc(Request $request, $id)
    {
        $suivi = Suivi_amelioration::find($id);
        if ($suivi)
        {
            $suivi->efficacite = $request->input('efficacite');
            $suivi->commentaire = $request->input('commentaire');
            $suivi->date_action = $request->input('date_action');
            $suivi->date_suivi = now()->format('Y-m-d\TH:i');
            $suivi->statut = 'realiser';
            $suivi->update();

            $suivi2 = Suivi_amelioration::where('amelioration_id', $suivi->amelioration_id)->where('statut', 'non-realiser')->count();

                if ($suivi2 === 0 ) {

                    $am = Amelioration::where('id', $suivi->amelioration_id)->first();
                    $am->date_cloture1 = $request->input('date_action');
                    $am->statut = 'date_efficacite';
                    $am->update();
                }

            if ($suivi)
            {

                $his = new Historique_action();
                $his->nom_formulaire = 'Suivi des actions corrective';
                $his->nom_action = 'Suivi éffectué';
                $his->user_id = Auth::user()->id;
                $his->save();

                return back()
                        ->with('success', 'Suivi éffectué.');
            }

        }

        return back()
            ->with('error', 'Suivi non éffectuée.');
    }  

}
