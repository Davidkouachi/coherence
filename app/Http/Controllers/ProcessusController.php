<?php

namespace App\Http\Controllers;

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

use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ProcessusController extends Controller
{
    public function index_add_processus()
    {
        return view('add.processus');
    }

    public function index_add_processuseva()
    {
        $processuses = Processuse::all();
        $postes = User::all();
        return view('add.processuseva', compact('processuses','postes'));
    }

    public function add_prc(Request $request)
    {

        $processus_id = $request->input('processus_id');

        $nom_risque = $request->input('nom_risque');
        $vrai = $request->input('vrai');
        $gravite = $request->input('gravite');
        $evaluation = $request->input('vrai') * $request->input('gravite');
        $cout = $request->input('cout');
        $vrai_residuel = $request->input('vrai_residuel');
        $gravite_residuel = $request->input('gravite_residuel');
        $evaluation_residuel = $request->input('vrai_residuel') * $request->input('gravite_residuel');
        $cout_residuel = $request->input('cout_residuel');
        $traitement = $request->input('traitement');

        $risque = new Risque();
        $risque->nom = $nom_risque;
        $risque->vraisemblence = $vrai;
        $risque->gravite = $gravite;
        $risque->evaluation = $evaluation;
        $risque->cout = $cout;
        $risque->vraisemblence_residuel = $vrai_residuel;
        $risque->gravite_residuel = $gravite_residuel;
        $risque->evaluation_residuel = $evaluation_residuel;
        $risque->cout_residuel = $cout_residuel;
        $risque->processus_id = $processus_id;
        $risque->traitement = $traitement;
        $risque->statut = 'soumis';
        $risque->save();

        if ($request->hasFile('pdfFile') && $request->file('pdfFile')->isValid()) {

            $originalFileName = $request->file('pdfFile')->getClientOriginalName();
            $pdfPathname = $request->file('pdfFile')->storeAs('public/pdf', $originalFileName);

            // Enregistrez le fichier PDF dans la base de données
            $pdfFile = new Pdf_file();
            $pdfFile->pdf_nom = $originalFileName;
            $pdfFile->pdf_chemin = $pdfPathname;
            $pdfFile->risque_id = $risque->id;
            $pdfFile->save();

            $risque_update = Risque::where('id', $risque->id)->first();
            $risque_update->statut = 'valider';
            $risque_update->save();
        }

        $nom_cause = $request->input('nom_cause');
        $dispositif = $request->input('dispositif');
        $validateur_id = $request->input('validateur_id');
        $risque_id = $risque->id;

        foreach ($nom_cause as $index => $valeur) {
            $cause = new Cause();
            $cause->nom = $nom_cause[$index];
            $cause->dispositif = $dispositif[$index];
            $cause->validateur_id = $validateur_id;
            $cause->risque_id = $risque_id;
            $cause->save();
        }

        $actionc = $request->input('actionc');
        $actionp = $request->input('actionp');
        $delai = $request->input('delai');
        $responsable_idp = $request->input('responsable_idp');
        $responsable_idc = $request->input('responsable_idc');

        foreach ($actionp as $index => $valeur) {

            if ($actionp[$index] !== '') {
                
                $nouvelleActionP = new Action();
                $nouvelleActionP->action = $actionp[$index];
                $nouvelleActionP->delai = $delai[$index];
                $nouvelleActionP->statut = 'non-realiser';
                $nouvelleActionP->responsable_id = $responsable_idp[$index];
                $nouvelleActionP->risque_id = $risque_id;
                $nouvelleActionP->type = 'preventive';
                $nouvelleActionP->save();

                $suivip = new Suivi_action();
                $suivip->risque_id = $risque_id;
                $suivip->action_id = $nouvelleActionP->id;
                $suivip->processus_id = $processus_id;
                $suivip->save();
            }
        }

        foreach ($actionc as $index => $valeur) {

            $nouvelleActionC = new Action();
            $nouvelleActionC->action = $actionc[$index];
            $nouvelleActionC->statut = 'non-realiser';
            $nouvelleActionC->responsable_id = $responsable_idc[$index];
            $nouvelleActionC->risque_id = $risque_id;
            $nouvelleActionC->type = 'corrective';
            $nouvelleActionC->save();

            $suivic = new Suivi_action();
            $suivic->risque_id = $risque_id;
            $suivic->action_id = $nouvelleActionC->id;
            $suivic->processus_id = $processus_id;
            $suivic->save();

        }

        return redirect()
            ->back()
            ->with('ajouter', 'Enregistrement éffectuée.');

    }

    public function recherche_processuseva($processusId)
    {
        $objectifs = Objectif::where('processus_id', $processusId)->get();
        return response()->json($objectifs);
    }

    public function index_validation_processus()
    {
        $risques = Risque::where('statut' ,'soumis')->get();

        $causesData = [];
        $actionsDatap = [];
        $actionsDatac = [];

        foreach($risques as $risque)
        {
            $risque_pdf = Pdf_file::where('risque_id', $risque->id)->first();
            if ($risque_pdf) {
                $risque->pdf_nom = $risque_pdf->pdf_nom;
            } else {
                // Gérer le cas où aucun enregistrement n'est trouvé
                $risque->pdf_nom = null; // Ou définissez-le comme vous le souhaitez
            }
            
            $processus = Processuse::where('id', $risque->processus_id)->first();
            $risque->nom_processus = $processus->nom;

            $actions = Action::join('users', 'actions.responsable_id', '=', 'users.id')
                ->where('actions.risque_id', $risque->id)
                ->select('actions.*','users.name as responsable_name')
                ->get();
            $risque->nbre_action = count($actions);

            $actionsp = Action::join('users', 'actions.responsable_id', '=', 'users.id')
                ->where('actions.risque_id', $risque->id)
                ->where('actions.type', 'preventive')
                ->select('actions.*','users.poste as responsable')
                ->get();

            $actionsDatap[$risque->id] = [];
            
            foreach($actionsp as $actionp)
            {
                $actionsDatap[$risque->id][] = [
                    'action' => $actionp->action,
                    'delai' => $actionp->delai,
                    'responsable' => $actionp->responsable,
                ];
            }

            $actionsc = Action::join('users', 'actions.responsable_id', '=', 'users.id')
                ->where('actions.risque_id', $risque->id)
                ->where('actions.type', 'corrective')
                ->select('actions.*','users.poste as responsable')
                ->get();

            $actionsDatac[$risque->id] = [];
            
            foreach($actionsc as $actionc)
            {
                $actionsDatac[$risque->id][] = [
                    'action' => $actionc->action,
                    'responsable' => $actionc->responsable,
                ];
            }

            $causes = Cause::join('users', 'causes.validateur_id', '=', 'users.id')
                ->where('causes.risque_id', $risque->id)
                ->select('causes.*','users.poste as validateur')
                ->get();
            $risque->nbre_cause = count($causes);

            foreach($causes->unique() as $caus)
            {
                $risque->validateur = $caus->validateur;
            }
            
            $causesData[$risque->id] = [];
            
            foreach($causes as $cause)
            {
                $causesData[$risque->id][] = [
                    'cause' => $cause->nom,
                    'dispositif' => $cause->dispositif,
                    'validateur' => $cause->validateur_name,
                ];
            }
        }

        return view('tableau.validecause', ['risques' => $risques, 'causesData' => $causesData, 'actionsDatap' => $actionsDatap , 'actionsDatac' => $actionsDatac]);
    }


    public function add_processus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nprocessus' => 'required',
            'objectifs' => 'required',
            'description' => 'required',
            'finalite' => 'required',
        ]);

        $validator->setCustomMessages([
            'nprocessus.required' => 'Saisie obligatoire.',
            'objectifs.required' => 'Saisie obligatoire.',
            'description.required' => 'Saisie obligatoire.',
            'finalite.required' => 'Saisie obligatoire.',
        ]);

        if ($validator->fails()) {
            return redirect()
                        ->route('index_add_processus')
                        ->withErrors($validator)
                        ->withInput();
        }

        $nomProcessus = $request->input('nprocessus');
        $descriptionProcessus = $request->input('description');
        $objectifs = $request->input('objectifs');
        $finalite = $request->input('finalite');

        $processus = new Processuse();
        $processus->nom = $nomProcessus;
        $processus->description = $descriptionProcessus;
        $processus->finalite = $finalite;
        $processus->save();

        foreach ($objectifs as $objectif) {
            $nouvelObjectif = new Objectif();
            $nouvelObjectif->processus_id = $processus->id;
            $nouvelObjectif->nom = $objectif;
            $nouvelObjectif->save();
        }

        return redirect()
            ->route('index_add_processus')
            ->with('ajouter', 'Enregistrement éffectuée.');

    }

    public function cause_valider($id)
    {
        $valide = Risque::where('id', $id)->first();
        $valide->date_validation = now()->format('Y-m-d\TH:i');
        $valide->statut = 'valider';
        $valide->update();
            

        return redirect()
            ->back()
            ->with('valider', 'Validation éffectuée.');

    }

    public function cause_rejet(Request $request, $id)
    {
        
        $rejet = new Rejet();
        $rejet->motif = $request->input('motif');
        $rejet->risque_id = $id;
        $rejet->save();
        
        if ($request->input('radio') === 'modifier')
        {
            
            $valide = Risque::where('id', $id)->first();
            $valide->statut = 'modifier';
            $valide->date_validation = now()->format('Y-m-d\TH:i');
            $valide->update();
            
        } elseif ($request->input('radio') === 'supprimer') {
            
            $valide = Risque::where('id', $id)->first();
            $valide->statut = 'supprimer';
            $valide->date_validation = now()->format('Y-m-d\TH:i');
            $valide->update();
        }

        return redirect()
            ->back()
            ->with('rejet', 'rejet éffectuée.');
        
    }

}
