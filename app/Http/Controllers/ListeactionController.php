<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Processuse;
use App\Models\Objectif;
use App\Models\Risque;
use App\Models\Cause;
use App\Models\Rejet;
use App\Models\Action;
use App\Models\Suivi_action;
use App\Models\Suivi_amelioration;
use App\Models\Pdf_file;
use App\Models\Pdf_file_processus;
use App\Models\User;
use App\Models\Historique_action;
use App\Models\Poste;

use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

use Twilio\Rest\Client;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ListeactionController extends Controller
{
    public function index_ap()
    {
        $actions = Action::join('postes', 'actions.poste_id', 'postes.id')
                        ->join('risques', 'actions.risque_id', 'risques.id')
                        ->join('processuses', 'risques.processus_id', 'processuses.id')
                        ->where('actions.type', 'preventive')
                        ->select('actions.*', 'processuses.nom as processus', 'risques.nom as risque','postes.nom as poste')
                        ->get();

        foreach ($actions as $action) {
            $suivi = Suivi_action::where('action_id', $action->id)->first();

            if ($suivi) {
                $action->suivi = 'oui';
                $action->date_action = $suivi->date_action;
                $action->date_suivi = $suivi->date_suivi;
                $action->commentaire = $suivi->commentaire;
                $action->efficacite = $suivi->efficacite;
            } else {
                $action->suivi = 'non';
            }
        }

        return view('liste.actionpreventive', ['actions' => $actions, 'suivi' => $suivi ]); // Utilisez $action->id au lieu de $request->id
    }


    public function index_ac_eff()
    {
        $actions = Suivi_amelioration::join('ameliorations', 'suivi_ameliorations.amelioration_id', 'ameliorations.id')
                        ->where('suivi_ameliorations.statut', 'realiser')
                        ->join('processuses', 'suivi_ameliorations.processus_id', 'processuses.id')
                        ->select('Suivi_ameliorations.*', 'processuses.nom as processus', 'ameliorations.type as type_am', 'ameliorations.statut as statut_am', 'ameliorations.date_validation as date_validation_am')
                        ->get();

        foreach ($actions as $action) {

            $ac = Action::join('risques', 'actions.risque_id', 'risques.id')
                            ->join('postes', 'actions.poste_id', 'postes.id')
                            ->where('actions.id', $action->action_id)
                            ->select('actions.*', 'risques.nom as risque', 'postes.nom as poste')
                            ->first();

            $action->risque = $ac->risque;
            $action->poste = $ac->poste;
            $action->action = $ac->action;
        }

        return view('liste.actioncorrectiveeff', ['actions' => $actions]);
    }

    public function index_ac()
    {
        $actions = Action::join('risques', 'actions.risque_id', 'risques.id')
                        ->join('processuses', 'risques.processus_id', 'processuses.id')
                        ->where('actions.type', 'corrective')
                        ->where('actions.page', 'risk')
                        ->select('actions.*', 'processuses.nom as processus', 'risques.nom as risque')
                        ->get();

        return view('liste.actioncorrective', ['actions' => $actions]);
    }
}
