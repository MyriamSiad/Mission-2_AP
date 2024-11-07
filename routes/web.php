<?php

use Illuminate\Support\Facades\Route;
// Chemin des contrôleurs
use App\Http\Controllers\connexionController;
use App\Http\Controllers\etatFraisController;
use App\Http\Controllers\gererFraisController;
use App\Http\Controllers\gererFraisComptableController;
// Création des groupes de routes
Route::controller(connexionController::class)->group(function () {
    Route::get('/', 'connecter')->name('chemin_connexion');
    Route::post('/', 'valider')->name('chemin_valider');
    Route::get(uri: '/deconnexion', action: 'deconnecter')->name(name: 'chemin_deconnexion');
});

Route::controller(etatFraisController::class)->group(function () {
    Route::get('/selectionMois', 'selectionnerMois')->name('chemin_selectionMois');
    Route::post('/listeFrais', 'voirFrais')->name('chemin_listeFrais');
});



Route::controller(gererFraisController::class)->group(function () {
    Route::get('/gererFrais', 'saisirFrais')->name('chemin_gestionFrais');
    Route::post('/sauvegarderFrais', 'sauvegarderFrais')->name('chemin_sauvegardeFrais');
});





/***** Mes Routes ****************/
Route::controller(gererFraisComptableController::class)->group(function () {
    //Route::get('/SuivieFrais', 'afficheVisiteur')->name('cheminVisiteur');
    Route::get('/Validation','afficheVisiteur')->name('cheminVisiteur');
    Route::post('/Validation', 'Validation')->name('cheminRemboursement');
    Route::get('/Edition', 'Fiches')->name('cheminEdition');
    Route::post('/EditionPDF', 'ExportePDF')->name('cheminEditionPDF');
   // Route::post('/EditionFiche','')->name('cheminEdition');

});


