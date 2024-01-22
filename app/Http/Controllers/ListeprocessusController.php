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
use App\Models\Poste;
use App\Models\User;
use App\Models\Amelioration;
use App\Models\Historique;
use App\Models\Pdf_file;
use App\Models\Pdf_file_processus;
use App\Events\NotificationEvent;

use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ListeprocessusController extends Controller
{
    public function index_listeprocessus()
    {
        $processus = Processuse::all();

        $objectifData = [];

        foreach ($processus as $processu) {

            $pdf = Pdf_file_processus::where('processus_id', $processu->id)->first();
            if ($pdf) {
                $processu->pdf_nom = $pdf->pdf_nom;
                $processu->pdf_chemin = $pdf->pdf_chemin;
            } else {
                // Gérer le cas où aucun enregistrement n'est trouvé
                $processu->pdf_nom = null;
                $processu->pdf_chemin = null; // Ou définissez-le comme vous le souhaitez
            }

            $processu->nbre = Objectif::where('processus_id', $processu->id)->count();
            $objectifs = Objectif::where('processus_id', $processu->id)->get();

            $objectifData[$processu->id] = [];
            foreach($objectifs as $objectif)
            {
                $objectifData[$processu->id][] = [
                    'objectif' => $objectif->nom,
                ];
            }
        }

        return view('liste.processus', ['processus' => $processus, 'objectifData' => $objectifData]);
    }

    public function suppr_processus($id)
    {
        return redirect()
            ->back()
            ->with('info', 'Aucun code.');

        
    }
}
