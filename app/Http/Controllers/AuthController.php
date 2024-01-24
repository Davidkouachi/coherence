<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

use App\Models\User;
use App\Models\Historique_action;
use App\Models\Poste;
use App\Models\Autorisation;

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
        Cache::flush();
        return view('auth.login');
    }

    public function view_registre()
    {
        return view('auth.registre');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
     
        $request->session()->invalidate();
     
        $request->session()->regenerateToken();
     
        return redirect('/');
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
                'suivi_active' => 'non',
                'fa' => 'non',
            ]);


            if ($user) {

                $poste = Poste::find($request->poste_id);
                $poste->occupe = 'oui';
                $poste->update();

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
                $auto->color_para = $request->color_para;

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
                    $mail->Subject = " Coordonnées utilisateur ";
                    $mail->Body = 'Bienvenue à Cohérence ! <br><br>'.'<br>'
                            . 'Voici vos Coordonnées pour vous connecter :<br>'
                            . 'Matricule : ' . $request->matricule.'<br>'
                            . 'Email : ' . $user->email . '<br>'
                            . 'Mot de passe : ' . $request->mdp.'<br>'
                            . 'NB : Veuillez modifier votre mot de passe après votre premiere connexion.';
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

            Auth::logoutOtherDevices($request->password);
            
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

        return redirect()->back()->withInput($request->only('email'))->with([
            'error_login' => 'Email ou Mot de passe Incorrect. Veuillez réessayer.',
        ]);
    }

}
