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
        $actions = Suivi_action::join('actions', 'suivi_actions.action_id', 'actions.id')
                                    ->join('postes', 'actions.poste_id', 'postes.id')
                                    ->join('risques', 'actions.risque_id', 'risques.id')
                                    ->join('processuses', 'risques.processus_id', 'processuses.id')
                                    ->where('actions.type', '=', 'preventive')
                                    ->where('Suivi_actions.statut', '=', 'realiser')
                                    ->select('Suivi_actions.*','actions.action as action', 'processuses.nom as processus', 'risques.nom as risque','postes.nom as poste', 'risques.nom as risque' )
                                    ->get();

        return view('liste.actionpreventive', ['actions' => $actions]);
    }

    public function index_ac()
    {
        $actions = Suivi_amelioration::join('ameliorations', 'suivi_ameliorations.amelioration_id', 'ameliorations.id')
                                    ->join('actions', 'ameliorations.action_id', 'actions.id')
                                    ->join('postes', 'actions.poste_id', 'postes.id')
                                    ->join('risques', 'actions.risque_id', 'risques.id')
                                    ->join('processuses', 'risques.processus_id', 'processuses.id')
                                    ->where('actions.type', '=', 'corrective')
                                    ->where('suivi_ameliorations.statut', '=', 'realiser')
                                    ->select('Suivi_ameliorations.*','actions.action as action', 'ameliorations.type as type', 'processuses.nom as processus', 'risques.nom as risque','postes.nom as poste' )
                                    ->get();

        return view('liste.actioncorrective', ['actions' => $actions]);
    }
}
