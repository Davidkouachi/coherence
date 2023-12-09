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

            $actionsp = Action::join('postes', 'actions.poste_id', '=', 'postes.id')
                ->where('actions.risque_id', $risque->id)
                ->where('actions.type', 'preventive')
                ->select('actions.*','postes.nom as responsable')
                ->get();
            $risque->nbre_actionp = count($actionsp);

            $actionsDatap[$risque->id] = [];
            
            foreach($actionsp as $actionp)
            {
                $actionsDatap[$risque->id][] = [
                    'action' => $actionp->action,
                    'date_suivip' => $actionp->date,
                    'type' => $actionp->type,
                    'responsable' => $actionp->responsable,
                ];
            }

            $actionsc = Action::join('postes', 'actions.poste_id', '=', 'postes.id')
                ->where('actions.risque_id', $risque->id)
                ->where('actions.type', 'corrective')
                ->select('actions.*','postes.nom as responsable')
                ->get();
                $risque->nbre_actionc = count($actionsc);

            $actionsDatac[$risque->id] = [];
            
            foreach($actionsc as $actionc)
            {
                $actionsDatac[$risque->id][] = [
                    'action' => $actionc->action,
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
        $risques = Risque::join('rejets', 'rejets.risque_id', '=', 'risques.id')
                ->join('postes', 'risques.poste_id', '=', 'postes.id')
                ->join('processuses', 'risques.processus_id', '=', 'processuses.id')
                ->where('statut' ,'non_valider')
                ->select('risques.*','processuses.nom as processus', 'rejets.motif as motif')
                ->get();

        return view('traitement.actionup', ['risques' => $risques ]);
    }

    public function index_risque_actionup2($id)
    {
        $risque = Risque::join('rejets', 'rejets.risque_id', '=', 'risques.id')
                ->join('postes', 'risques.poste_id', '=', 'postes.id')
                ->where('risques.id', $id)
                ->select('risques.*','postes.nom as validateur', 'rejets.motif as motif','postes.id as poste_id')
                ->first();

        $causesData = [];
        $actionsDatap = [];
        $actionsDatac = [];

        if($risque)
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

            $actionsp = Action::join('postes', 'actions.poste_id', '=', 'postes.id')
                ->where('actions.risque_id', $risque->id)
                ->where('actions.type', 'preventive')
                ->select('actions.*','postes.nom as responsable', 'postes.id as poste_id')
                ->get();
            $risque->nbre_actionp = count($actionsp);

            $actionsDatap[$risque->id] = [];
            
            foreach($actionsp as $actionp)
            {
                $actionsDatap[$risque->id][] = [
                    'action_idp' => $actionp->id,
                    'action' => $actionp->action,
                    'date_suivip' => $actionp->date,
                    'responsable' => $actionp->responsable,
                    'poste_idp' => $actionp->poste_id,
                ];
            }

            $actionsc = Action::join('postes', 'actions.poste_id', '=', 'postes.id')
                ->where('actions.risque_id', $risque->id)
                ->where('actions.type', 'corrective')
                ->select('actions.*','postes.nom as responsable', 'postes.id as poste_id')
                ->get();
            $risque->nbre_actionc = count($actionsc);

            $actionsDatac[$risque->id] = [];
            
            foreach($actionsc as $actionc)
            {
                $actionsDatac[$risque->id][] = [
                    'action_idc' => $actionc->id,
                    'action' => $actionc->action,
                    'responsable' => $actionc->responsable,
                    'poste_idc' => $actionc->poste_id,
                ];
            }

            $causes = Cause::where('causes.risque_id', $risque->id)->get();
            $risque->nbre_cause = count($causes);
            
            $causesData[$risque->id] = [];
            
            foreach($causes as $cause)
            {
                $causesData[$risque->id][] = [
                    'cause_id' => $cause->id,
                    'cause' => $cause->nom,
                    'dispositif' => $cause->dispositif,
                    'validateur' => $risque->validateur,
                ];
            }
        }

        $postes = Poste::join('users', 'users.poste_id', 'postes.id')
                        ->select('postes.*') // Sélectionne les colonnes de la table 'postes'
                        ->distinct() // Rend les résultats uniques
                        ->get();

        return view('traitement.actionup2', ['risque' => $risque, 'causesData' => $causesData, 'actionsDatap' => $actionsDatap , 'actionsDatac' => $actionsDatac, 'postes' => $postes ]);
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
