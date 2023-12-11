<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Historique_action;
use App\Models\Poste;

use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class AuthController extends Controller
{
    public function dashboard()
    {
        if (Auth::check()) {

            return view('add.processus');

        } else {

            return redirect()->route('login');

        }
    }
    
    public function view_login()
    {
        return view('auth.login');
    }

    public function view_registre()
    {
        return view('auth.registre');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        return redirect()->route('login');
    }

    public function add_user(Request $request)
    {
        $user_vrf = User::where('email', $request->email)
                        ->orWhere('tel', $request->tel)
                        ->first();
        if ($user_vrf) {
            if ($user_vrf->email === $request->email) {
                return back()->with('error', 'Email existe déjà.');
            } else {
                return back()->with('error', 'Contact existe déjà.');
            }
        } else {

            $user = User::create([
                'name' => $request->np,
                'email' => $request->email,
                'password' => bcrypt($request->mdp),
                'matricule' => $request->matricule,
                'tel' => $request->tel,
                'poste_id' => $request->poste_id,
            ]);

            if ($user) {

                $auto = new Autorisation();
                $auto->new_user = $request->new_user;
                $auto->list_user = $request->list_user;
                $auto->new_poste = $request->new_poste;
                $auto->list_poste = $request->list_poste;
                $auto->historiq = $request->historiq;
                $auto->stat = $request->stat;

                $auto->new_proces = $request->new_proces;
                $auto->list_proces = $request->list_proces;
                $auto->eva_proces = $request->eva_proces;

                $auto->new_risk = $request->new_risk;
                $auto->list_risk = $request->list_risk;
                $auto->val_risk = $request->val_risk;
                $auto->act_n_val = $request->act_n_val;

                $auto->suivi_actp = $request->suivi_actp;
                $auto->list_actp = $request->list_actp;

                $auto->suivi_actc = $request->suivi_actc;
                $auto->list_actc_eff = $request->list_actc_eff;
                $auto->list_actc = $request->list_actc;

                $auto->fiche_am = $request->fiche_am;
                $auto->list_am = $request->list_am;
                $auto->val_am = $request->val_am;
                $auto->am_n_val = $request->am_n_val;

                $auto->user_id = $user->id;
                $auto->save();

                if ($auto) {

                    $his = new Historique_action();
                    $his->nom_formulaire = 'Nouveau Utilisateur';
                    $his->nom_action = 'Ajouter';
                    $his->user_id = Auth::user()->id;
                    $his->save();

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
                    $mail->Subject = 'Coordonnées utilisateur';
                    $mail->Body = 'Bienvenue à Cohérence ! <br><br>'.'<br>'
                            . 'Voici vos informations pour vous connecter :<br>'
                            . 'Matricule : ' . $request->matricule.'<br>'
                            . 'Email : ' . $user->email . '<br>'
                            . 'Mot de passe : ' . $request->mdp.'<br>'
                            . 'NB : Vous pouvez modifier le mot de passe selon votre choix.';
                    // Envoi de l'email
                    $mail->send();

                    return back()->with('success', 'Enregistrement éffectuée.');
                }

            }

            return back()->with('error', 'Enregistrement a échoué.');
        }
    }


    public function auth_user(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            Auth::user()->logoutOtherDevices($request->password);
            
            $poste_id = Auth::user()->poste_id;
            $user_id = Auth::user()->id;

            $poste = Poste::find($poste_id);
            if ($poste) {
                session(['user_poste' => $poste]);
            }

            $auto = Autorisation::where('user_id', $user_id)->first();
            if ($auto) {
                session(['user_auto' => $auto]);
            }

            return redirect()->intended(route('index_accueil'));
        }

        return back()->with('error_login', 'Coordonnées incorrecte.');
    }

    public function verifi_session(Request $request)
    {
        $mdp = Auth::user()->password;
        $verifi_mdp = bcrypt($request->input('password'));

        if ($mdp === $verifi_mdp) {
            return back();
        }
    }

}
