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

use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class EvaluationController extends Controller
{
    public function index()
    {
        $processus = Processuse::all();
        $risquesData = [];

        foreach ($processus as $processu) {
            $risques = Risque::where('processus_id', $processu->id)->get();

            if ($risques) {
                $processu->nbre_risque = $risques->count();

                $totalEvaluation = 0;
                $risquesData[$processu->id] = [];

                foreach ($risques as $risque)
                {
                    $totalEvaluation += $risque->evaluation_residuel;

                    $risquesData[$processu->id][] = [
                        'nom' => $risque->nom,
                        'evaluation_residuel' => $risque->evaluation_residuel,
                    ];
                }

                if ($risques->count() > 0) {
                    $evagg = $totalEvaluation / $risques->count();
                    $evag = number_format($evagg, 1);
                } else {
                    $evag = 0;
                }

                $processu->evag = $evag;
            } else {
                $processu->nbre_risque = 0;
                $processu->evag = 0;
            }

        }

        return view('tableau.evaproces',['processus' => $processus, 'risquesData' => $risquesData]);
    }
}
