<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Processuse;
use App\Models\Objectif;
use App\Models\Risque;
use App\Models\Risque_am;
use App\Models\Cause;
use App\Models\Cause_am;
use App\Models\Rejet;
use App\Models\Action;
use App\Models\Action_am;
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
        $actions = Suivi_action::join('actions', 'suivi_actions.action_id', 'actions.id')
                                    ->join('postes', 'actions.poste_id', 'postes.id')
                                    ->join('risques', 'actions.risque_id', 'risques.id')
                                    ->join('processuses', 'risques.processus_id', 'processuses.id')
                                    ->where('actions.type', '=', 'preventive')
                                    ->where('actions.accepte', '=', 'oui')
                                    ->select('Suivi_actions.*','actions.action as action', 'processuses.nom as processus', 'risques.nom as risque','postes.nom as poste', 'risques.nom as risque' )
                                    ->get();

        return view('liste.actionpreventive', ['actions' => $actions]);
    }

    public function index_ac()
    {
        $actions = Suivi_amelioration::join('ameliorations', 'suivi_ameliorations.amelioration_id', 'ameliorations.id')
                        ->join('processuses', 'suivi_ameliorations.processus_id', 'processuses.id')
                        ->select('Suivi_ameliorations.*', 'processuses.nom as processus', 'ameliorations.type as type_am')
                        ->get();

        foreach ($actions as $action) {

            if ($action->nature === 'new') {

                $ac = Action_am::join('risque_ams', 'action_ams.risque_id_am', 'risque_ams.id')
                                ->join('postes', 'action_ams.poste_id', 'postes.id')
                                ->where('action_ams.id', $action->action_id)
                                ->select('action_ams.*', 'risque_ams.nom as risque', 'postes.nom as poste')
                                ->first();

                $action->risque = $ac->risque;
                $action->poste = $ac->poste;
                $action->action = $ac->action;

            } else if ($action->nature === 'non-accepte') {

                $ac = Action_am::join('risques', 'action_ams.risque_id', 'risques.id')
                                ->join('postes', 'action_ams.poste_id', 'postes.id')
                                ->where('action_ams.id', $action->action_id)
                                ->select('action_ams.*', 'risques.nom as risque', 'postes.nom as poste')
                                ->first();

                $action->risque = $ac->risque;
                $action->poste = $ac->poste;
                $action->action = $ac->action;

            } else if ($action->nature === 'accepte') {

                $ac = Action::join('risques', 'actions.risque_id', 'risques.id')
                            ->join('postes', 'actions.poste_id', 'postes.id')
                            ->where('actions.id', $action->action_id)
                            ->where('actions.accepte', '=', 'oui')
                            ->select('actions.*', 'risques.nom as risque', 'postes.nom as poste')
                            ->first();

                $action->risque = $ac->risque;
                $action->poste = $ac->poste;
                $action->action = $ac->action;

            }
        }

        return view('liste.actioncorrective', ['actions' => $actions]);
    }
}
