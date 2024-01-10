<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ProcessusController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ResvaController;
use App\Http\Controllers\SuiviactionController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\AmeliorationController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\StatistiqueController;
use App\Http\Controllers\ListeprocessusController;
use App\Http\Controllers\ListerisqueController;
use App\Http\Controllers\ListeactionController;
use App\Http\Controllers\EtatController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\ListeamController;
use App\Http\Controllers\ListeuserController;
use App\Http\Controllers\Updateamcontroller;
use App\Http\Controllers\ParamettreController;


Route::get('/Login', [AuthController::class, 'view_login'])->name('login');
Route::post('/auth_user', [AuthController::class, 'auth_user']);

Route::get('/Registre', [AuthController::class, 'view_registre'])->name('registre');

Route::middleware(['auth'])->group(function () {

    Route::get('/Color paramettre', [ParamettreController::class, 'index_color_risk'])->name('index_color_risk');
    Route::post('/Color paramettre traitement', [ParamettreController::class, 'color_para_traitement'])->name('color_para_traitement');
    Route::post('/Color interval add traitement', [ParamettreController::class, 'color_interval_add_traitement'])->name('color_interval_add_traitement');
    Route::get('/Color_interval_delete_traitement/{id}', [ParamettreController::class, 'color_interval_delete_traitement'])->name('color_interval_delete_traitement');

    Route::get('/suiviactiveoui', [ProfilController::class, 'suivi_oui']);
    Route::get('/suiviactivenon', [ProfilController::class, 'suivi_non']);
    Route::get('/mdp_update', [ProfilController::class, 'mdp_update']);
    Route::get('/info_update', [ProfilController::class, 'info_update']);

    Route::get('/', [Controller::class, 'index_accueil'])->name('index_accueil');

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/Liste des utilisateurs', [ListeuserController::class, 'index'])->name('index_liste_resva');
    Route::post('/Modif', [ListeuserController::class, 'index_modif'])->name('index_modif_auto');

    Route::get('/Nouveau Processus', [ProcessusController::class, 'index_add_processus'])->name('index_add_processus');

    Route::get('/Liste Poste', [Controller::class, 'index_liste_poste'])->name('index_liste_poste');
    Route::post('/Nouveau Poste', [Controller::class, 'index_add_poste_traitement'])->name('index_add_poste_traitement');
    Route::post('/Mise a jour Poste', [Controller::class, 'index_modif_poste_traitement'])->name('index_modif_poste_traitement');
    Route::get('/get-post-user', [Controller::class, '/get_post_user'])->name('get_post_user');

    Route::post('/traitement_processus', [ProcessusController::class, 'add_processus'])->name('add_processus');

    Route::get('/Nouveau Processus Eva', [ProcessusController::class, 'index_add_processuseva'])->name('index_add_processuseva');
    Route::get('/recherche/{processusId}', [ProcessusController::class, 'recherche_processuseva'])->name('recherche_processuseva');
    Route::post('/traitement_prc', [ProcessusController::class, 'add_prc'])->name('add_prc');

    Route::get('/Validation', [ProcessusController::class, 'index_validation_processus'])->name('index_validation_processus');
    Route::get('/cause_valider/{id}', [ProcessusController::class, 'cause_valider'])->name('cause_valider');
    Route::post('/rejet', [ProcessusController::class, 'cause_rejet'])->name('cause_rejet');

    Route::get('/Liste processus', [ListeprocessusController::class, 'index_listeprocessus'])->name('index_listeprocessus');
    Route::get('/suppr_processus/{id}', [ListeprocessusController::class, 'suppr_processus'])->name('suppr_processus');

    Route::get('/Liste risque', [ListerisqueController::class, 'index_liste_risque'])->name('index_liste_risque');
    Route::get('/Mise a jour', [ListerisqueController::class, 'index_risque_actionup'])->name('index_risque_actionup');
    Route::post('/Mise a jour risque', [ListerisqueController::class, 'index_risque_actionup2'])->name('index_risque_actionup2');
    Route::post('/Mise a jour risque traitement', [ListerisqueController::class, 'index_risque_actionup2_traitement'])->name('index_risque_actionup2_traitement');

    Route::get('/Liste Action Preventive', [ListeactionController::class, 'index_ap'])->name('index_ap');
    Route::get('/Liste Action Corrective effectuée', [ListeactionController::class, 'index_ac_eff'])->name('index_ac_eff');
    Route::get('/Liste Action Corrective', [ListeactionController::class, 'index_ac'])->name('index_ac');

    Route::post('/traitement_resva', [ResvaController::class, 'add_resva'])->name('add_resva');
    Route::post('/add_user', [AuthController::class, 'add_user'])->name('add_user');

    Route::get('/Suivi_action', [SuiviactionController::class, 'index_suiviaction'])->name('index_suiviaction');
    Route::get('/Suivi_actionc', [SuiviactionController::class, 'index_suiviactionc'])->name('index_suiviactionc');
    Route::post('/Suivi_action/{id}', [SuiviactionController::class, 'add_suivi_action'])->name('add_suivi_action');
    Route::post('/Suivi_actionc/{id}', [SuiviactionController::class, 'add_suivi_actionc'])->name('add_suivi_actionc');

    Route::get('/Eva_proces', [EvaluationController::class, 'index'])->name('index_evaluation');

    Route::get('/fiche_amelioration', [AmeliorationController::class, 'index'])->name('index_amelioration');
    Route::get('/get-cause-info/{id}', [AmeliorationController::class, 'get_cause_info']);
    Route::get('/get-risque-info/{id}', [AmeliorationController::class, 'get_risque_info']);
    Route::post('/add_amelioration', [AmeliorationController::class, 'index_add'])->name('index_add');
    Route::get('/liste_amelioration', [AmeliorationController::class, 'index_liste'])->name('index_amelioration_liste');
    Route::get('/validation_amelioration', [ListeamController::class, 'index_validation'])->name('index_validation_amelioration');
    Route::get('/amelioration_up', [ListeamController::class, 'index_amup'])->name('index_amup');
    Route::post('/amelioration_up2', [ListeamController::class, 'index_amup2'])->name('index_amup2');
    Route::post('/amelioration_up_add', [ListeamController::class, 'index_amup_add'])->name('index_amup_add');
    Route::get('/am_valider/{id}', [ListeamController::class, 'am_valider'])->name('am_valider');
    Route::post('/am_rejet', [ListeamController::class, 'am_rejet'])->name('am_rejet');

    Route::post('/amelioration_up_traitement', [Updateamcontroller::class, 'amup_traitement'])->name('amup_traitement');
    Route::post('/amelioration_up2_traitement', [Updateamcontroller::class, 'amup2_traitement'])->name('amup2_traitement');
    Route::post('/amelioration_up2_add_traitement', [Updateamcontroller::class, 'amup2_add_traitement'])->name('amup2_add_traitement');
    Route::get('/am_update/{id}', [Updateamcontroller::class, 'am_update'])->name('am_update');

    Route::get('/Profil', [ProfilController::class, 'index_profil'])->name('index_profil');

    Route::get('/Historique', [SuiviactionController::class, 'index_historique'])->name('index_historique');
    Route::get('/Historique Profil', [SuiviactionController::class, 'index_historique_profil'])->name('index_historique_profil');

    Route::get('/Statistique', [StatistiqueController::class, 'index_stat'])->name('index_stat');
    Route::get('/get_processus/{id}', [StatistiqueController::class, 'get_processus'])->name('get_processus');
    Route::get('/get_date', [StatistiqueController::class, 'get_date'])->name('get_date');

    Route::get('/Res-va', [ResvaController::class, 'index_add_resva'])->name('index_add_resva');
    Route::post('/traitement_resva', [ResvaController::class, 'add_resva'])->name('add_resva');
    Route::post('/add_user', [AuthController::class, 'add_user'])->name('add_user');

    Route::get('/Nouveau Poste', [Controller::class, 'index_add_poste'])->name('index_add_poste');
    Route::post('/Nouveau Poste', [Controller::class, 'index_add_poste_traitement'])->name('index_add_poste_traitement');

    Route::get('/Etat_am', [EtatController::class, 'index_etat_am'])->name('index_etat_am');

    Route::get('/etat_pdf', [EtatController::class, 'download'])->name('generate_PDF');
});


/*--------------------------------------------------------------------------------------------------------------*/



