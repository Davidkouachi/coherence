<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Poste;

class Controller extends BaseController
{
    //use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index_accueil()
    {
        return view('menu');
    }

    public function index_add_poste()
    {
        return view('add.poste');
    }

    public function index_add_poste_traitement(Request $request)
    {
        $nom = $request->input('nom');

        foreach ($nom as $nom) {
            $poste = new Poste();
            $poste->nom = $nom;
            $poste->save();
        }
        

        return back()
            ->with('ajouter', 'Enregistrement éffectuée.');
    }

    public function get_post_user() 
    {
        $postes = Poste::all(); // Récupération de tous les postes depuis la base de données
        return response()->json(['postes' => $postes]);
    }
}
