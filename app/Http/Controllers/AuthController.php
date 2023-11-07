<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Historique_action;

use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

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
        $user = User::create([
            'name' => $request->np,
            'email' => $request->email,
            'password' => bcrypt($request->mdp),
            'matricule' => $request->matricule,
            'tel' => $request->tel,
            'poste' => $request->poste,
        ]);

        if ($user) {

            $his = new Historique_action();
            $his->nom_formulaire = 'Nouvel utilisateur';
            $his->nom_action = 'Ajouter';
            $his->user_id = Auth::user()->id;
            $his->save();
        }

        return back()->with('ajouter', 'Enregistrement éffectuée.');
    }

    public function auth_user(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {

            Auth::user()->logoutOtherDevices($request->password);
            
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
