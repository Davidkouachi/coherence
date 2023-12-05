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

use Dompdf\Dompdf;
use Dompdf\Options;

class PDFController extends Controller
{
    public function generatePDF()
    {
        // Options de configuration pour Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);

        // Créer une instance de Dompdf avec les options
        $dompdf = new Dompdf($options);

        // Afficher l'en-tête et le pied de page
        $header = view('etat_imprimer.header'); // Remplacez 'pdf.header' par votre vue d'en-tête
        $footer = view('etat_imprimer.footer'); // Remplacez 'pdf.footer' par votre vue de pied de page

        // Récupérer le contenu de la vue à convertir en PDF
        $content = view('etat_imprimer.amelioration')->render(); // Remplacez 'pdf.your-view' par votre vue Blade

        // Compiler le HTML
        $html = $header . $content . $footer;

        // Charger le contenu HTML dans Dompdf
        $dompdf->loadHtml($html);

        // Rendre le PDF
        $dompdf->render();

        // Télécharger ou afficher le PDF
        return $dompdf->stream('document.pdf');
    }
}

