<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Events\NotificationAcorrective;
use App\Events\NotificationApreventive;
use App\Events\NotificationAnon;
use App\Events\NotificationProcessus;
use App\Events\NotificationRisque;

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
use App\Models\Amelioration;
use App\Models\Suivi_amelioration;


use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

use Twilio\Rest\Client;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use PDF;

class EtatController extends Controller
{
    public function index_etat_am(Request $request)
    {
        $am = Amelioration::find($request->id);

        $actionsData = [];

        if ($am) {

            $am->nbre_action = Suivi_amelioration::where('amelioration_id', '=', $am->id)->count();

            $suivi = Suivi_amelioration::where('amelioration_id', '=', $am->id)->get();

            $actionsData[$am->id] = [];

            foreach ($suivi as $suivis) {

                $action = Action::join('postes', 'actions.poste_id', 'postes.id')
                                ->join('risques', 'actions.risque_id', 'risques.id')
                                ->join('processuses', 'risques.processus_id', 'processuses.id')
                                ->where('actions.id', '=', $suivis->action_id)
                                ->select('actions.*', 'postes.nom as poste', 'processuses.nom as processus', 'risques.nom as risque')
                                ->first();

                if ($action) {
                    $actionsData[$am->id][] = [
                        'action' => $action->action,
                        'responsable' => $action->poste,
                        'delai' => $suivis->delai,
                        'date_action' => $suivis->date_action,
                        'date_suivi' => $suivis->date_suivi,
                        'statut' => $suivis->statut,
                        'processus' => $action->processus,
                        'risque' => $action->risque,
                        'commentaire' => $suivis->commentaire_am,
                        'efficacite' => $suivis->efficacite,
                    ];
                }

            }
        }

        return view('etat.amelioration', ['am' => $am, 'actionsData' => $actionsData ]);
        
    }
}
