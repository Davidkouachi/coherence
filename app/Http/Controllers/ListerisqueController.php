<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Events\NotificationAup;
use App\Events\NotificationRisqueup;

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

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


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

    public function index_risque_actionup2(Request $request)
    {
        $risque = Risque::join('rejets', 'rejets.risque_id', '=', 'risques.id')
                ->join('postes', 'risques.poste_id', '=', 'postes.id')
                ->where('risques.id', '=' ,$request->id)
                ->select('risques.*','postes.nom as validateur', 'rejets.motif as motif','postes.id as poste_id')
                ->first();

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
            $risque->processus_id = $processus->id;

            $actionsp = Action::join('postes', 'actions.poste_id', '=', 'postes.id')
                ->where('actions.risque_id', $risque->id)
                ->where('actions.type', 'preventive')
                ->select('actions.*','postes.nom as responsable', 'postes.id as poste_id')
                ->get();

            $actionsc = Action::join('postes', 'actions.poste_id', '=', 'postes.id')
                ->where('actions.risque_id', $risque->id)
                ->where('actions.type', 'corrective')
                ->select('actions.*','postes.nom as responsable', 'postes.id as poste_id')
                ->get();

            $causes = Cause::where('causes.risque_id', $risque->id)->get();

            $postes = Poste::join('users', 'users.poste_id', 'postes.id')
                        ->select('postes.*') // Sélectionne les colonnes de la table 'postes'
                        ->distinct() // Rend les résultats uniques
                        ->get();

            $processuses = Processuse::all();

            return view('traitement.actionup2', ['risque' => $risque, 'causes' => $causes, 'actionsp' => $actionsp , 'actionsc' => $actionsc, 'postes' => $postes, 'processuses' => $processuses]);
            
        }

    }

    public function index_risque_actionup2_traitement(Request $request)
    {

        $processus_id = $request->input('processus_id');

        $risque_id = $request->input('risque_id');
        $nom_risque = $request->input('risque');
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

        $risque = Risque::where('id', $risque_id)->first();

        if ($risque) {

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
            $risque->statut = 'update';
            $risque->update();

            if ($request->hasFile('pdfFile') && $request->file('pdfFile')->isValid()) {

                $originalFileName = $request->file('pdfFile')->getClientOriginalName();
                $pdfPathname = $request->file('pdfFile')->storeAs('public/pdf', $originalFileName);

                // Enregistrez le fichier PDF dans la base de données
                $pdfFile = Pdf_file::where('risque_id', $risque_id)->first();

                if ($pdfFile) {

                    $pdfFile->pdf_nom = $originalFileName;
                    $pdfFile->pdf_chemin = $pdfPathname;
                    $pdfFile->update();
                } else {

                    $pdfFile = new Pdf_file();
                    $pdfFile->pdf_nom = $originalFileName;
                    $pdfFile->pdf_chemin = $pdfPathname;
                    $pdfFile->risque_id = $risque_id;
                    $pdfFile->save();
                }

            }

            $cause_id = $request->input('cause_id');
            $nom_cause = $request->input('nom_cause');
            $dispositif = $request->input('dispositif');
            $cause_id_suppr = $request->input('cause_id_suppr');
            $suppr_cause = $request->input('suppr_cause');

            foreach ($cause_id as $index => $valeur) {

                if ($cause_id[$index] !== '0') {

                    $cause = Cause::where('id', $cause_id[$index])->first();

                    if ($cause) {

                        $cause->nom = $nom_cause[$index];
                        $cause->dispositif = $dispositif[$index];
                        $cause->update();
                    }


                } else {

                    $cause = new Cause();
                    $cause->nom = $nom_cause[$index];
                    $cause->dispositif = $dispositif[$index];
                    $cause->risque_id = $risque_id;
                    $cause->save();
                }

            }

            if ($cause_id_suppr) {

                foreach ($cause_id_suppr as $index => $valeur) {

                    if ($suppr_cause[$index] === 'oui') {

                        $cause = Cause::where('id', $cause_id_suppr[$index])->delete();

                    }
                }
            }


            $action_idc = $request->input('action_idc');
            $actionc = $request->input('actionc');
            $responsable_idc = $request->input('poste_idc');
            $action_idc_suppr = $request->input('action_idc_suppr');
            $suppr_actionc = $request->input('suppr_actionc');

            foreach ($action_idc as $index => $valeur) {

                if ($action_idc[$index] !== '0') {
                    
                    $nouvelleActionC = Action::where('id', $action_idc[$index])->first();

                    if ($nouvelleActionC) {

                        $nouvelleActionC->action = $actionc[$index];
                        $nouvelleActionC->poste_id = $responsable_idc[$index];
                        $nouvelleActionC->update();
                    }

                } else {

                    $nouvelleActionC = new Action();
                    $nouvelleActionC->action = $actionc[$index];
                    $nouvelleActionC->poste_id = $responsable_idc[$index];
                    $nouvelleActionC->risque_id = $risque_id;
                    $nouvelleActionC->type = 'corrective';
                    $nouvelleActionC->save();
                }
            }

            if ($action_idc_suppr) {

                foreach ($action_idc_suppr as $index => $valeur) {

                    if ($suppr_actionc[$index] === 'oui') {

                        $action = Action::where('id', $action_idc_suppr[$index])->delete();

                    }
                }
            }


            $action_idp = $request->input('action_idp');
            $actionp = $request->input('actionp');
            $delai = $request->input('delai');
            $responsable_idp = $request->input('poste_idp');
            $action_idp_suppr = $request->input('action_idp_suppr');
            $suppr_actionp = $request->input('suppr_actionp');

            foreach ($action_idp as $index => $valeur) {

                if ($action_idp[$index] !== '0') {
                    
                    $nouvelleActionP = Action::where('id', $action_idp[$index])->first();

                    if ($nouvelleActionP) {

                        $nouvelleActionP->action = $actionp[$index];
                        $nouvelleActionP->poste_id = $responsable_idp[$index];
                        $nouvelleActionP->date = $delai[$index];
                        $nouvelleActionP->update();
                    }

                } else {

                    $nouvelleActionP = new Action();
                    $nouvelleActionP->action = $actionp[$index];
                    $nouvelleActionP->poste_id = $responsable_idp[$index];
                    $nouvelleActionP->risque_id = $risque_id;
                    $nouvelleActionP->date = $delai[$index];
                    $nouvelleActionP->type = 'preventive';
                    $nouvelleActionP->save();

                }
            }

            if ($action_idp_suppr) {

                foreach ($action_idp_suppr as $index => $valeur) {

                    if ($suppr_actionp[$index] === 'oui') {

                        $action = Action::where('id', $action_idp_suppr[$index])->delete();

                    }
                }
            }


            event(new NotificationRisqueup());

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
                $mail->Body = 'Mise à jour d´/une fiche risque Risque';
                // Envoi de l'email
                $mail->send();
            }

            return redirect()->route('index_risque_actionup')->with('success', 'Modification éffectuée.');

        }

    }
}
