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

                $his = new Historique_action();
                $his->nom_formulaire = 'Nouveau Utilisateur';
                $his->nom_action = 'Ajouter';
                $his->user_id = Auth::user()->id;
                $his->save();
            }

            return back()->with('success', 'Enregistrement éffectuée.');
        }
    }

    public function auth_user(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            Auth::user()->logoutOtherDevices($request->password);
            $id = Auth::user()->poste_id;
            $poste = Poste::find($id);

            return redirect()->intended(route('index_accueil', ['poste' => $poste]));
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
