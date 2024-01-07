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
use App\Models\Pdf_file;
use App\Models\Pdf_file_processus;
use App\Models\User;
use App\Models\Historique_action;
use App\Models\Poste;
use App\Models\Color_para;
use App\Models\Color_interval;

use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

use Twilio\Rest\Client;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use Illuminate\Support\Facades\Session;

class ParamettreController extends Controller
{
    public function index_color_risk()
    {
        $color_para = Color_para::where('nbre0', '=', '0')->first();

        $color_intervals = Color_interval::orderBy('nbre1', 'asc')->get();
        $color_interval_nbre = count($color_intervals);

        $color_interval_dernier = Color_interval::orderBy('nbre1', 'desc')->latest()->first();


        return view('add.color_risque',[
            'color_para' => $color_para,
            'color_intervals' => $color_intervals,'color_interval_nbre' => $color_interval_nbre,
            'color_interval_dernier' => $color_interval_dernier,
        ]);
    }

    public function color_para_traitement(Request $request)
    {
        $color_para = Color_para::where('nbre0', '=', '0')->first();

        if ($request->operation != $color_para->operation) {
            Color_interval::truncate();
        }

        $color_para->nbre1 = $request->nbre1;
        $color_para->nbre2 = $request->nbre2;
        $color_para->nbre_color = $request->nbre_color;
        $color_para->operation = $request->operation;

        if ($color_para->save()) {
            return redirect()->back()->with(['success' => 'Mise à jour effectuée.']);
        }

        return redirect()->back()->with(['error' => 'Échec de la mise à jour.']);
    }


    public function color_interval_add_traitement(Request $request)
    {

        if ( $request->nbre1 >= $request->nbre2){
            return redirect()->back()->with(['info' => 'le deuxieme nombre doit toujours etre supérieur.']);
        }

        $color_interval = new Color_interval();
        $color_interval->nbre1 = $request->nbre1;
        $color_interval->nbre2 = $request->nbre2;
        $color_interval->color = $request->color;

        if($color_interval->save()) {
            return redirect()->back()->with(['success' => 'Nouvel interval ajouté.']);
        }

        return redirect()->back()->with(['error' => 'Echec.']);
    }

    public function color_interval_delete_traitement($id)
    {
        $delete = Color_interval::find($id);
        $delete->delete();
        
        if($delete) {
            return redirect()->back()->with(['success' => 'Suppression éffectuée.']);
        }

        return redirect()->back()->with(['error' => 'Echec de la suppression.']);
    }
}
