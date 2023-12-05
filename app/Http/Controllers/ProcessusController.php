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

use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

use Twilio\Rest\Client;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ProcessusController extends Controller
{
    public function index_add_processus()
    {

        return view('add.processus');
    }

    public function index_add_processuseva()
    {

        $processuses = Processuse::all();
        $postes = Poste::join('users', 'users.poste_id', 'postes.id')
                        ->select('postes.*') // Sélectionne les colonnes de la table 'postes'
                        ->distinct() // Rend les résultats uniques
                        ->get();

        return view('add.processuseva', ['processuses' => $processuses, 'postes' => $postes]);
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
        $validateur = $request->input('poste_id');

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
        $risque->poste_id = $validateur;
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
        }

        $nom_cause = $request->input('nom_cause');
        $dispositif = $request->input('dispositif');
        $risque_id = $risque->id;

        foreach ($nom_cause as $index => $valeur) {
            $cause = new Cause();
            $cause->nom = $nom_cause[$index];
            $cause->dispositif = $dispositif[$index];
            $cause->risque_id = $risque_id;
            $cause->save();
        }

        $actionc = $request->input('actionc');
        $actionp = $request->input('actionp');
        $delai = $request->input('delai');
        $responsable_idp = $request->input('poste_idp');
        $responsable_idc = $request->input('poste_idc');

        foreach ($actionp as $index => $valeur) {

            if ($actionp[$index] !== '') {
                
                $nouvelleActionP = new Action();
                $nouvelleActionP->action = $actionp[$index];
                $nouvelleActionP->poste_id = $responsable_idp[$index];
                $nouvelleActionP->risque_id = $risque_id;
                $nouvelleActionP->type = 'preventive';
                $nouvelleActionP->accepte = 'non_valider';
                $nouvelleActionP->save();

                $suivip = new Suivi_action();
                $suivip->delai = $delai[$index];
                $suivip->statut = 'non-realiser';
                $suivip->risque_id = $risque_id;
                $suivip->action_id = $nouvelleActionP->id;
                $suivip->processus_id = $processus_id;
                $suivip->save();
            }
        }

        foreach ($actionc as $index => $valeur) {

            $nouvelleActionC = new Action();
            $nouvelleActionC->action = $actionc[$index];
            $nouvelleActionC->poste_id = $responsable_idc[$index];
            $nouvelleActionC->risque_id = $risque_id;
            $nouvelleActionC->type = 'corrective';
            $nouvelleActionC->accepte = 'non_valider';
            $nouvelleActionC->save();

        }

        if ($risque || $cause || $nouvelleActionP || $suivip || $nouvelleActionC || $suivic)
        {
            $choix_alert_alert = $request->input('choix_alert_alert');
            $choix_alert_email = $request->input('choix_alert_email');
            $choix_alert_sms = $request->input('choix_alert_sms');

            if ($choix_alert_alert === 'alert') {

                event(new NotificationRisque());

            }

            if ($choix_alert_email === 'email') {

                $user = User::join('postes', 'users.poste_id', 'postes.id')
                            ->where('postes.id', $validateur)
                            ->select('users.*')
                            ->first();
                if ($user) {

                    $mail = new PHPMailer(true);
                    $mail->isHTML(true);
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'coherencemail01@gmail.com';
                    $mail->Password = 'kiur ejgn ijqt kxam';
                    $mail->SMTPSecure = 'ssl';
                    $mail->Port = 465;
                    // Destinataire, sujet et contenu de l'email
                    $mail->setFrom('coherencemail01@gmail.com', 'Coherence');
                    $mail->addAddress($user->email);
                    $mail->Subject = 'ALERT !';
                    $mail->Body = 'Nouveau Risque';
                    // Envoi de l'email
                    $mail->send();
                }

            }

            if ($choix_alert_sms === 'sms') {

            }

            $his = new Historique_action();
            $his->nom_formulaire = 'Nouveau Risque';
            $his->nom_action = 'Ajouter';
            $his->user_id = Auth::user()->id;
            $his->save();

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
        $risques = Risque::join('postes', 'risques.poste_id', '=', 'postes.id')
                ->where('statut' ,'soumis')
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
                ->select('actions.*','postes.nom as responsable', 'postes.id as poste_id')
                ->get();
            $risque->nbre_actionp = count($actionsp);

            $actionsDatap[$risque->id] = [];
            
            foreach($actionsp as $actionp)
            {
                $actionsDatap[$risque->id][] = [
                    'action_idp' => $actionp->id,
                    'action' => $actionp->action,
                    'accepte' => $actionp->accepte,
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
                    'accepte' => $actionc->accepte,
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
                    'cause' => $cause->nom,
                    'dispositif' => $cause->dispositif,
                    'validateur' => $risque->validateur,
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

        if ($request->hasFile('pdfFile') && $request->file('pdfFile')->isValid()) {

            $originalFileName = $request->file('pdfFile')->getClientOriginalName();
            $pdfPathname = $request->file('pdfFile')->storeAs('public/pdf', $originalFileName);

            // Enregistrez le fichier PDF dans la base de données
            $pdfFile = new Pdf_file_processus();
            $pdfFile->pdf_nom = $originalFileName;
            $pdfFile->pdf_chemin = $pdfPathname;
            $pdfFile->processus_id = $processus->id;
            $pdfFile->save();
        }

        foreach ($objectifs as $objectif) {
            $nouvelObjectif = new Objectif();
            $nouvelObjectif->processus_id = $processus->id;
            $nouvelObjectif->nom = $objectif;
            $nouvelObjectif->save();
        }

        if ($processus)
        {
            $his = new Historique_action();
            $his->nom_formulaire = 'Nouveau Processus';
            $his->nom_action = 'Ajouter';
            $his->user_id = Auth::user()->id;
            $his->save();

            event(new NotificationProcessus());
        }

        return redirect()
            ->route('index_add_processus')
            ->with('ajouter', 'Enregistrement éffectuée.');

    }

    public function cause_valider(Request $request)
    {
        $risque_id = $request->input('risque_id');

        $action_idp = $request->input('action_idp');
        $poste_idp = $request->input('poste_idp');
        $acceptep = $request->input('acceptep');
        $commentairep = $request->input('commentairep');

        if ($action_idp) {

            foreach ($action_idp as $index => $valeur) {
                $action = Action::where('id', $action_idp[$index])->first();
                $action->accepte = $acceptep[$index];
                $action->commentaire = $commentairep[$index];
                $action->update();
            }
        }

        $action_idc = $request->input('action_idc');
        $poste_idc = $request->input('poste_idc');
        $acceptec = $request->input('acceptec');
        $commentairec = $request->input('commentairec');

        if ($action_idc) {

            foreach ($action_idc as $index => $valeur) {
                $action = Action::where('id', $action_idc[$index])->first();
                $action->accepte = $acceptec[$index];
                $action->commentaire = $commentairec[$index];
                $action->update();
            }
        }

        $actions = Action::where('risque_id', $risque_id)->where('accepte', '!=' ,'oui')->count();

            if ($actions >= 1 ) {
                
                $user = User::join('postes', 'users.poste_id', 'postes.id')
                        ->where('postes.nom', 'OPÉRATEUR DE SAISIE')
                        ->select('users.*')
                        ->first();

                $mail = new PHPMailer(true);
                $mail->isHTML(true);
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'coherencemail01@gmail.com';
                $mail->Password = 'kiur ejgn ijqt kxam';
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465;
                // Destinataire, sujet et contenu de l'email
                $mail->setFrom('coherencemail01@gmail.com', 'Coherence');
                $mail->addAddress($user->email);
                $mail->Subject = 'ALERT !';
                $mail->Body = 'Action non accepté';
                // Envoi de l'email
                $mail->send();

                event(new NotificationAnon());

                $his = new Historique_action();
                $his->nom_formulaire = 'Tableau de validation';
                $his->nom_action = 'Action non approuvé';
                $his->user_id = Auth::user()->id;
                $his->save();

                return redirect()
                    ->back()
                    ->with('ajouter', 'Modification éffectuée.');
            } else {

                $valide = Risque::where('id', $risque_id)->first();
                $valide->date_validation = now()->format('Y-m-d\TH:i');
                $valide->statut = 'valider';
                $valide->update();

                if ($valide)
                {
                    $his = new Historique_action();
                    $his->nom_formulaire = 'Tableau de validation';
                    $his->nom_action = 'Validation';
                    $his->user_id = Auth::user()->id;
                    $his->save();

                    $user = User::join('postes', 'users.poste_id', 'postes.id')
                                ->where('postes.id', $valide->poste_id)
                                ->select('users.*')
                                ->first();

                    $mail = new PHPMailer(true);
                    $mail->isHTML(true);
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'coherencemail01@gmail.com';
                    $mail->Password = 'kiur ejgn ijqt kxam';
                    $mail->SMTPSecure = 'ssl';
                    $mail->Port = 465;
                    // Destinataire, sujet et contenu de l'email
                    $mail->setFrom('coherencemail01@gmail.com', 'Coherence');
                    $mail->addAddress($user->email);
                    $mail->Subject = 'ALERT !';
                    $mail->Body = 'Nouvelle Action Préventive';
                    // Envoi de l'email
                    $mail->send();

                    event(new NotificationApreventive());
                }

                return redirect()
                    ->back()
                    ->with('valider', 'Validation éffectuée.');

            }

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

            if ($valide || $rejet)
            {
                $his = new Historique_action();
                $his->nom_formulaire = 'Tableau de validation';
                $his->nom_action = 'Rejet -> Modification';
                $his->user_id = Auth::user()->id;
                $his->save();
            }
            
        } elseif ($request->input('radio') === 'supprimer') {
            
            $valide = Risque::where('id', $id)->first();
            $valide->statut = 'supprimer';
            $valide->date_validation = now()->format('Y-m-d\TH:i');
            $valide->update();

            if ($valide || $rejet)
            {
                $his = new Historique_action();
                $his->nom_formulaire = 'Tableau de validation';
                $his->nom_action = 'Rejet -> Supprimer';
                $his->user_id = Auth::user()->id;
                $his->save();
            }
        }

        return redirect()
            ->back()
            ->with('rejet', 'rejet éffectuée.');
        
    }

}
