<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

use App\Models\Processuse;
use App\Models\Objectif;
use App\Models\Risque;
use App\Models\Cause;
use App\Models\Rejet;
use App\Models\Action;
use App\Models\Suivi_action;
use App\Models\Pdf_file;
use App\Models\User;
use App\Models\Historique_action;
use App\Models\Poste;
use App\Models\Amelioration;
use App\Models\Suivi_amelioration;

use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class StatistiqueController extends Controller
{

    public function index_stat()
    {
        $types = ['non_conformite_interne', 'reclamation', 'contentieux'];

        $statistics = [];

        foreach ($types as $type) {
            $statistics[$type] = [];

            $statistics[$type]['total'] = Amelioration::where('ameliorations.type', $type)->count();

            $statistics[$type]['causes'] = Amelioration::where('ameliorations.type', $type)->where('choix_select', 'cause')->count();

            $statistics[$type]['risques'] = Amelioration::where('ameliorations.type', $type)->where('choix_select', 'risque')->count();
                
            $statistics[$type]['causes_risques_nt'] = Amelioration::where('ameliorations.type', $type)->where('choix_select', 'cause_risque_nt')->count();
        }

        $processus = Processuse::all();
        $nbre_processus = $processus->count();
        $nbre_risque = Risque::all()->count();
        $nbre_cause = Cause::all()->count();

        
        $nbre_ap = Action::where('type', 'preventive')->count();
        $nbre_ed_ap = Suivi_action::join('actions', 'actions.id', '=', 'suivi_actions.action_id')
                                    ->whereNotNull('suivi_actions.date_action')
                                    ->whereColumn('actions.date', '>=', 'suivi_actions.date_action')
                                    ->count();
        $nbre_ehd_ap = Suivi_action::join('actions', 'actions.id', '=', 'suivi_actions.action_id')
                                    ->whereNotNull('suivi_actions.date_action')
                                    ->whereColumn('actions.date', '<', 'suivi_actions.date_action')
                                    ->count();
        $nbre_hd_ap = Suivi_action::where('statut', '=', 'non-realiser')->count();


        $nbre_ac = Action::where('type', 'corrective')->count();
        $nbre_ed_ac = Suivi_amelioration::join('actions', 'actions.id', '=', 'suivi_ameliorations.action_id')
                                    ->whereNotNull('suivi_ameliorations.date_action')
                                    ->whereColumn('actions.date', '>=', 'suivi_ameliorations.date_action')
                                    ->count();
        $nbre_ehd_ac = Suivi_amelioration::join('actions', 'actions.id', '=', 'suivi_ameliorations.action_id')
                                    ->whereNotNull('suivi_ameliorations.date_action')
                                    ->whereColumn('actions.date', '<', 'suivi_ameliorations.date_action')
                                    ->count();
        $nbre_hd_ac = Suivi_amelioration::where('statut', '=', 'non-realiser')->count();



        return view('statistique.index', ['statistics' => $statistics, 'processus' => $processus, 'nbre_processus' => $nbre_processus, 'nbre_risque' => $nbre_risque, 'nbre_cause' => $nbre_cause, 'nbre_ap' => $nbre_ap, 'nbre_ac' => $nbre_ac, 'nbre_ed_ap' => $nbre_ed_ap,'nbre_ehd_ap' => $nbre_ehd_ap,'nbre_hd_ap' => $nbre_hd_ap , 'nbre_ed_ac' => $nbre_ed_ac,'nbre_ehd_ac' => $nbre_ehd_ac,'nbre_hd_ac' => $nbre_hd_ac]);
    }

    public function get_processus($id)
    {
        $processus = Processuse::find($id);

        $types = ['non_conformite_interne', 'reclamation', 'contentieux'];
        $nbres = [];

        foreach ($types as $type) {
            $nbres[$type] = amelioration::join('risques', 'ameliorations.risque_id', 'risques.id')
                                            ->join('processuses', 'risques.processus_id', 'processuses.id')
                                            ->where('ameliorations.type', $type)
                                            ->where('processuses.id', $id)
                                            ->count();
        }

        return response()->json([
            'data' => array_values($nbres),
        ]);
    }

    public function get_date(Request $request)
    {
        $date1 = Carbon::parse($request->input('date1'))->format('Y-m-d');
        $date2 = Carbon::parse($request->input('date2'))->format('Y-m-d');

        $types = ['non_conformite_interne', 'reclamation', 'contentieux'];
        $nbres = [];

        foreach ($types as $type) {
            $nbres[$type] = Amelioration::where('ameliorations.date_fiche', '>=', $date1)
                                        ->where('ameliorations.date_fiche', '<=', $date2)
                                        ->where('ameliorations.type', $type)
                                        ->count();
        }

        return response()->json([
            'data' => array_values($nbres),
        ]);
    }


}
