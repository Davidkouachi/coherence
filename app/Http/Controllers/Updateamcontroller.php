<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Events\NotificationAcorrective;
use App\Events\NotificationApreventive;
use App\Events\NotificationAnon;
use App\Events\NotificationProcessus;
use App\Events\NotificationRisque;
use App\Events\NotificationAup;
use App\Events\NotificationAmvalider;
use App\Events\NotificationAmcorrective;
use App\Events\NotificationAmrejet;

use App\Models\Processuse;
use App\Models\Amelioration;
use App\Models\Objectif;
use App\Models\Risque;
use App\Models\Cause;
use App\Models\Rejet;
use App\Models\Rejet_am;
use App\Models\Action;
use App\Models\Suivi_action;
use App\Models\Pdf_file;
use App\Models\Pdf_file_processus;
use App\Models\User;
use App\Models\Historique_action;
use App\Models\Poste;
use App\Models\Suivi_amelioration;

use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

use Twilio\Rest\Client;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Updateamcontroller extends Controller
{
    public function amup_traitement(Request $request)
    {
        
    }

    public function amup2_traitement(Request $request)
    {
        $amelioration_id = $request->input('amelioration_id');
        $type = $request->input('type');

        $date_fichee = $request->input('date_fiche');
        $dateCarbon = Carbon::createFromFormat('Y-m-d', $date_fichee);
        $date_fiche = $dateCarbon->format('Y-m-d');

        $lieu = $request->input('lieu');
        $detecteur = $request->input('detecteur');
        $non_conformite = $request->input('non_conformite');
        $consequence = $request->input('consequence');
        $cause = $request->input('cause');

        $am = Amelioration::find($amelioration_id);
        $am->type = $type;
        $am->date_fiche = $date_fiche;
        $am->lieu =$lieu;
        $am->detecteur = $detecteur;
        $am->non_conformite = $non_conformite;
        $am->consequence = $consequence;
        $am->cause = $cause;
        $am->statut = 'modif';
        $am->update();

        if ($am) {

            $suivi_id = $request->input('suivi_id');
            $delai = $request->input('delai');
            $commentaire_am = $request->input('commentaire_am');

            foreach ($suivi_id as $index => $value) {

                $suivi = Suivi_amelioration::find($suivi_id[$index]);
                $suivi->delai = $delai[$index];
                $suivi->commentaire_am = $commentaire_am[$index];
                $suivi->update();
            }

            $id_suppr = $request->input('id_suppr');
            $suppr = $request->input('suppr');

            if ($id_suppr) {
                foreach ($id_suppr as $index => $valeur) {
                    if (isset($suppr[$index]) && $suppr[$index] === 'oui') {
                        $delete_action = Suivi_amelioration::where('id', $valeur)->delete();
                    }
                }
            }

            return redirect()->route('index_amup')->with('success', 'Mise à jour éffectuée.');
        }

        return redirect()->route('index_amup')->with('error', 'Echec de la mise à jour');
    }

    public function amup2_add_traitement(Request $request)
    {
        $trouve = $request->input('trouve');
        $trouve_id = $request->input('trouve_id');

        $nature = $request->input('nature');
        $processus_id = $request->input('processus_id');
        $risque = $request->input('risque');
        $resume = $request->input('resume');
        $action = $request->input('action');
        $action_id = $request->input('action_id');
        $poste_id = $request->input('poste_id');
        $date_action = $request->input('date_action');
        $commentaire = $request->input('commentaire');

        $am = Amelioration::where('id', '=', $request->amelioration_id)->first();
        $am->statut = 'modif';
        $am->update();

        foreach ($nature as $index => $valeur) {

            $risque_id = $risque[$index];

            if ($nature[$index] === 'accepte') {

                $suivic = new Suivi_amelioration();
                $suivic->delai = $date_action[$index];
                $suivic->type = 'action';
                $suivic->nature = $nature[$index];
                $suivic->trouve = $trouve[$index];
                $suivic->statut = 'non-realiser';
                $suivic->amelioration_id = $am->id;
                $suivic->action_id = $action_id[$index];
                $suivic->processus_id = $processus_id[$index];
                $suivic->risque_id = $risque[$index];
                if ($trouve[$index] === 'cause') {$suivic->cause_id = $trouve_id[$index];}
                if ($trouve[$index] === 'risque') {$suivic->risque_id = $trouve_id[$index];}
                $suivic->commentaire_am = $commentaire[$index];
                $suivic->save();

            }

            if ($nature[$index] === 'non-accepte') {

                $actionn = new Action();
                $actionn->action = $action[$index];
                $actionn->page = 'am';
                $actionn->type = 'corrective';
                $actionn->poste_id = $poste_id[$index];
                $actionn->risque_id = $risque[$index];
                $actionn->save();

                $suivic = new Suivi_amelioration();
                $suivic->delai = $date_action[$index];
                $suivic->type = 'action_am';
                $suivic->nature = $nature[$index];
                $suivic->trouve = $trouve[$index];
                $suivic->statut = 'non-realiser';
                $suivic->amelioration_id = $am->id;
                $suivic->action_id = $actionn->id;
                $suivic->risque_id = $risque[$index];
                $suivic->processus_id = $processus_id[$index];
                if ($trouve[$index] === 'cause') {$suivic->cause_id = $trouve_id[$index];}
                if ($trouve[$index] === 'risque') {$suivic->risque_id = $trouve_id[$index];}
                $suivic->commentaire_am = $commentaire[$index];
                $suivic->save();

            }

            if ($nature[$index] === 'new') {

                $risquee = new Risque();
                $risquee->nom = $risque[$index];
                $risquee->page = 'am';
                $risquee->processus_id = $processus_id[$index];
                $risquee->poste_id = $poste_id[$index];
                $risquee->save();

                $cause = new Cause();
                $cause->nom = $resume[$index];
                $cause->page = 'am';
                $cause->risque_id = $risquee->id;
                $cause->save();

                $actionn = new Action();
                $actionn->action = $action[$index];
                $actionn->page = 'am';
                $actionn->type = 'corrective';
                $actionn->poste_id = $poste_id[$index];
                $actionn->risque_id = $risquee->id;
                $actionn->save();

                $suivic = new Suivi_amelioration();
                $suivic->delai = $date_action[$index];
                $suivic->type = 'action_am';
                $suivic->nature = $nature[$index];
                $suivic->trouve = 'new_risque';
                $suivic->statut = 'non-realiser';
                $suivic->amelioration_id = $am->id;
                $suivic->action_id = $actionn->id;
                $suivic->risque_id = $risquee->id;
                $suivic->cause_id = $cause->id;
                $suivic->processus_id = $processus_id[$index];
                $suivic->commentaire_am = $commentaire[$index];
                $suivic->save();
            }

        }

        if ($am) {

            return redirect()->route('index_amup')->with('success', 'Mise à jour éffectuée.');

        } else {
            return redirect()->route('index_amup')->with('error', 'Echec de la mise à jour');
        }
    }

    public function am_update($id)
    {
        $valide = Amelioration::where('id', $id)->first();

        if ($valide)
        {

            $valide->statut = 'update';
            $valide->update();

            return redirect()
                    ->back()
                    ->with('success', 'Validation éffectuée.');

        }

        return redirect()
            ->back()
            ->with('error', 'Validation a échoué.');
    }
}
