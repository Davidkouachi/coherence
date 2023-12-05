<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Events\NotificationAup;

use App\Models\Processuse;
use App\Models\Objectif;
use App\Models\Risque;
use App\Models\Cause;
use App\Models\Rejet;
use App\Models\Action;
use App\Models\Suivi_action;
use App\Models\Pdf_file;
use App\Models\Pdf_file_processus;
use App\Models\User;
use App\Models\Historique_action;
use App\Models\Poste;

use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;


class ListerisqueController extends Controller
{
    public function index_liste_risque()
    {
        $risques = Risque::join('postes', 'risques.poste_id', '=', 'postes.id')
                ->select('risques.*','postes.nom as validateur')
                ->get();

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

            $actionsc = Action::join('postes', 'actions.poste_id', '=', 'postes.id')
                ->where('actions.risque_id', $risque->id)
                ->where('actions.type', 'corrective')
                ->select('actions.*','postes.nom as responsable_name')
                ->get();
            $risque->nbre_actionc = count($actionsc);

            $actionsp = Action::join('postes', 'actions.poste_id', '=', 'postes.id')
                ->where('actions.risque_id', $risque->id)
                ->where('actions.type', 'preventive')
                ->select('actions.*','postes.nom as responsable_name')
                ->get();
            $risque->nbre_actionp = count($actionsp);

            $actionsp = Action::join('postes', 'actions.poste_id', '=', 'postes.id')
                ->where('actions.risque_id', $risque->id)
                ->where('actions.type', 'preventive')
                ->select('actions.*','postes.nom as responsable')
                ->get();

            $actionsDatap[$risque->id] = [];
            
            foreach($actionsp as $actionp)
            {
                $actionsDatap[$risque->id][] = [
                    'action' => $actionp->action,
                    'accepte' => $actionp->accepte,
                    'type' => $actionp->type,
                    'responsable' => $actionp->responsable,
                ];
            }

            $actionsc = Action::join('postes', 'actions.poste_id', '=', 'postes.id')
                ->where('actions.risque_id', $risque->id)
                ->where('actions.type', 'corrective')
                ->select('actions.*','postes.nom as responsable')
                ->get();

            $actionsDatac[$risque->id] = [];
            
            foreach($actionsc as $actionc)
            {
                $actionsDatac[$risque->id][] = [
                    'action' => $actionc->action,
                    'accepte' => $actionc->accepte,
                    'responsable' => $actionc->responsable,
                ];
            }

            $causes = Cause::where('causes.risque_id', $risque->id)->get();
            $risque->nbre_cause = count($causes);
            
            $causesData[$risque->id] = [];
            
            foreach($causes as $cause)
            {
                $causesData[$risque->id][] = [
                    'cause' => $cause->nom,
                    'dispositif' => $cause->dispositif,
                    'validateur' => $risque->validateur,
                ];
            }
        }

        return view('liste.risque', ['risques' => $risques, 'causesData' => $causesData, 'actionsDatap' => $actionsDatap , 'actionsDatac' => $actionsDatac]);
    }

    public function index_risque_actionup()
    {
        $risques = Risque::join('postes', 'risques.poste_id', '=', 'postes.id')
                        ->join('actions', 'actions.risque_id', '=', 'risques.id')
                        ->where('actions.accepte', '=', 'non')
                        ->where('risques.statut','soumis')
                        ->select('risques.*','postes.nom as validateur')
                        ->distinct()
                        ->get();

        $actionsDatap = [];
        $actionsDatac = [];

        foreach($risques as $risque)
        {
            $processus = Processuse::where('id', $risque->processus_id)->first();
            $risque->nom_processus = $processus->nom;

            $actionsc = Action::join('postes', 'actions.poste_id', '=', 'postes.id')
                ->where('actions.risque_id', $risque->id)
                ->where('actions.accepte', 'non')
                ->where('actions.type', 'corrective')
                ->select('actions.*','postes.nom as responsable_name')
                ->get();
            if ($actionsc) { $risque->nbre_actionc = count($actionsc); } else { $risque->nbre_actionc = 0;  }
            $actionsDatac[$risque->id] = [];
            foreach($actionsc as $actionc)
            {
                $actionsDatac[$risque->id][] = [
                    'action_idc' => $actionc->id,
                    'action' => $actionc->action,
                    'commentaire' => $actionc->commentaire,
                    'accepte' => $actionc->accepte,
                    'responsable' => $actionc->responsable,
                ];
            }

            $actionsp = Action::join('postes', 'actions.poste_id', '=', 'postes.id')
                ->where('actions.risque_id', $risque->id)
                ->where('actions.accepte', 'non')
                ->where('actions.type', 'preventive')
                ->select('actions.*','postes.nom as responsable_name')
                ->get();
            if ($actionsp) { $risque->nbre_actionp = count($actionsp); } else { $risque->nbre_actionp = 0; }
            $actionsDatap[$risque->id] = [];
            foreach($actionsp as $actionp)
            {
                $actionsDatap[$risque->id][] = [
                    'action_idp' => $actionp->id,
                    'action' => $actionp->action,
                    'commentaire' => $actionp->commentaire,
                    'accepte' => $actionp->accepte,
                    'responsable' => $actionp->responsable,
                ];
            }
        }

        return view('traitement.actionup', ['risques' => $risques, 'actionsDatap' => $actionsDatap , 'actionsDatac' => $actionsDatac]);
    }

    public function action_update(Request $request)
    {
        $action_idp = $request->input('action_idp');
        $actionp = $request->input('actionp');
        $commentairep = $request->input('commentairep');

        if($action_idp) {

            foreach ($action_idp as $index => $value) {
                $action = Action::find($action_idp[$index]); // Récupère l'action par son ID

                if ($action) {
                    if ($action->action !== $actionp[$index]) {

                        $action->action = $actionp[$index]; // Met à jour l'action
                        $action->accepte = 'modif';
                        $action->save(); // Enregistre les modifications
                    }

                }
            }
        }

        $action_idc = $request->input('action_idc');
        $actionc = $request->input('actionc');
        $commentairec = $request->input('commentairec');

        if($action_idc) {

            foreach ($action_idc as $index => $value) {
                $action = Action::find($action_idc[$index]); // Récupère l'action par son ID

                if ($action) {
                    if ($action->action !== $actionc[$index]) {

                        $action->action = $actionc[$index]; // Met à jour l'action
                        $action->accepte = 'modif';
                        $action->save(); // Enregistre les modifications
                    }
                }
            }
        }

        if ($action) {

            event(new NotificationAup());

            $his = new Historique_action();
            $his->nom_formulaire = 'Action non validé';
            $his->nom_action = 'Mise à jour';
            $his->user_id = Auth::user()->id;
            $his->save();
        }

        return back()->with('valider', 'Mise à jour effectuée.');
    }

}
