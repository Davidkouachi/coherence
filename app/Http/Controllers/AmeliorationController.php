<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Processuse;
use App\Models\Objectif;
use App\Models\Resva;
use App\Models\Risque;
use App\Models\Cause;
use App\Models\Rejet;
use App\Models\Action;
use App\Models\Suivi_action;

use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class AmeliorationController extends Controller
{
   public function index()
   {
        $risques = Risque::all();

        $causesData = [];
        $actionsData = [];

        foreach($risques as $risque)
        {
            $processus = Processuse::where('id', $risque->processus_id)->first();
            $risque->nom_processus = $processus->nom;

            $actions = Action::join('resvas', 'actions.responsable_id', '=', 'resvas.id')
                ->where('actions.risque_id', $risque->id)
                ->select('actions.*','resvas.nom as responsable_nom')
                ->get();

            $actionsData[$risque->id] = [];
            
            foreach($actions as $action)
            {
               $Suivi_action = Suivi_action::where('action_id', $action->id)->first();
               $actionsData[$risque->id][] = [
                    'actionc' => $action->actionc,
                    'actionp' => $action->actionp,
                    'delai' => $action->delai,
                    'traitement' => $action->traitement,
                    'responsable' => $action->responsable_nom,
                    'statut' => $action->statut,
                    'date_action' => $Suivi_action->date_action,
                    'date_suivi' => $Suivi_action->date_suivi,
                    'efficacite' => $Suivi_action->efficacite,
                ];
            }

            $causes = Cause::join('resvas', 'causes.validateur_id', '=', 'resvas.id')
                ->where('causes.risque_id', $risque->id)
                ->select('causes.*','resvas.nom as validateur_nom')
                ->get();
            $risque->nbre_cause = count($causes);

            foreach($causes->unique() as $caus)
            {
                $risque->validateur = $caus->validateur_nom;
            }
            
            $causesData[$risque->id] = [];
            
            foreach($causes as $cause)
            {
                $causesData[$risque->id][] = [
                    'cause' => $cause->nom,
                    'dispositif' => $cause->dispositif,
                    'validateur' => $cause->validateur_nom,
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

            $risques2 = Risque::where('id', $causes_select->risque_id )->first();
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

            $processus2 = Processuse::where('id', $risques2->processus_id)->first();
            $causes_select->nom_processus = $processus2->nom;

            $causes2 = Cause::join('resvas', 'causes.validateur_id', '=', 'resvas.id')
                ->where('causes.risque_id', $causes_select->risque_id)
                ->select('causes.*','resvas.nom as validateur_nom')
                ->get();

            foreach($causes2->unique() as $caus2)
            {
                $causes_select->validateur = $caus2->validateur_nom;
            }

            $causesData2[$causes_select->risque_id] = [];

            foreach($causes2 as $caus2)
            {
               $causesData2[$caus2->risque_id][] = [
                    'cause' => $caus2->nom,
                    'dispositif' => $caus2->dispositif,
                    'validateur' => $caus2->validateur_nom,
                ];
            }

            $actions2 = Action::join('resvas', 'actions.responsable_id', '=', 'resvas.id')
                  ->where('actions.risque_id', $causes_select->risque_id)
                  ->select('actions.*','resvas.nom as responsable_nom')
                  ->get();

            $actionsData2[$causes_select->risque_id] = [];

                  
            foreach($actions2 as $action2)
            {
               $Suivi_action2 = Suivi_action::where('action_id', $action2->id)->first();
               $actionsData2[$Suivi_action2->risque_id][] = [
                    'actionc' => $action2->actionc,
                    'actionp' => $action2->actionp,
                    'delai' => $action2->delai,
                    'traitement' => $action2->traitement,
                    'responsable' => $action2->responsable_nom,
                    'statut' => $action2->statut,
                    'date_action' => $Suivi_action2->date_action,
                    'date_suivi' => $Suivi_action2->date_suivi,
                    'efficacite' => $Suivi_action2->efficacite,
                ];
            }
              
        }

        return view('add.ficheamelioration', 
            ['risques' => $risques, 'causesData' => $causesData, 'actionsData' => $actionsData, 
            'causes_selects' => $causes_selects, 'Suivi_action2' => $Suivi_action2, 'caus2' => $caus2, 'causesData2' => $causesData2, 'actionsData2' => $actionsData2]);
   }
    

}
