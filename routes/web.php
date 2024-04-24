<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\mainController;
use App\Http\Controllers\echipeController;
use App\Http\Controllers\jucatoriController;
use App\Http\Controllers\meciuriController;
use App\Http\Controllers\statisticiSiEvenimenteController;
use App\Http\Controllers\clasamentController;
use App\Http\Controllers\adminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

Route::get('/test', function () {
    return view('test');
});

Route::get('/home', [mainController::class, 'home']);

Route::get('/club-info/{numeEchipa}/info', [mainController::class, 'echipaIndex']);
Route::get('/club-info/{numeEchipa}/statistici/{faza}', [mainController::class, 'echipaStatistici']);
Route::get('/club-info/{numeEchipa}/meciuri', [mainController::class, 'echipaMeciuri']);
Route::get('/club-info/{numeEchipa}/rezultate', [mainController::class, 'echipaRezultate']);
Route::get('/club-info/{numeEchipa}/statistici-jucatori', [mainController::class, 'echipaStatisticiJucatori']);

Route::get('/jucator-info/{numeEchipa}/{numeJucator}/{faza}', [mainController::class, 'jucatorIndex']);
Route::any('/jucatori/{page}', [mainController::class, 'jucatoriIndex']);

Route::get('/clasament/{faza}', [mainController::class, 'clasamentIndex']);

Route::get('/meciuri/{faza}', [mainController::class, 'meciuriIndex']);
Route::get('/meciuri/{faza}/{etapa}', [mainController::class, 'meciuriIndex']);
Route::get('/meciuri', [mainController::class, 'meciuriIndex']);

Route::get('/meci/{meciID}/info', [mainController::class, 'meciInfo']);
Route::get('/meci/{meciID}/loturi', [mainController::class, 'meciLoturi']);
Route::get('/meci/{meciID}/evenimente', [mainController::class, 'meciEvenimente']);

Route::get('/statistici/{faza}', [mainController::class, 'statistici']);



Route::get('/admin', function () {
    return view('admin/admin');
})->middleware('auth');

Route::get('/admin-log-in', [adminController::class, 'login']);
Route::post('/admin-auth', [adminController::class, 'authenticate']);
Route::get('/admin-log-out', [adminController::class, 'logout'])->middleware('auth');

Route::get('/admin-echipe-index', [echipeController::class, 'indexAdmin'])->middleware('auth');
Route::get('/admin-echipe-add', [echipeController::class, 'create'])->middleware('auth');
Route::post('/admin-echipe-store', [echipeController::class, 'store'])->middleware('auth');
Route::get('/admin-echipe-edit/{id}', [echipeController::class, 'edit'])->middleware('auth');
Route::post('/admin-echipe-update', [echipeController::class, 'update'])->middleware('auth');
Route::get('/admin-echipe-delete/{id}', [echipeController::class, 'destroy'])->middleware('auth');
// Route::get('/echipa/{id}', [Echipe_22_23_Controller::class, 'show'])->middleware('auth');

Route::any('/admin-jucatori-index/{page}', [jucatoriController::class, 'indexAdmin'])->middleware('auth');
Route::get('/admin-jucatori-add', [jucatoriController::class, 'create'])->middleware('auth');
Route::post('/admin-jucatori-store', [jucatoriController::class, 'store'])->middleware('auth');
Route::get('/admin-jucatori-edit/{id}', [jucatoriController::class, 'edit'])->middleware('auth');
Route::post('/admin-jucatori-update', [jucatoriController::class, 'update'])->middleware('auth');
Route::get('/admin-jucatori-delete/{id}', [jucatoriController::class, 'destroy'])->middleware('auth');

Route::any('/admin-meciuri-index', [meciuriController::class, 'indexAdmin'])->middleware('auth');
Route::get('/admin-meciuri-add', [meciuriController::class, 'create'])->middleware('auth');
Route::post('/admin-meciuri-store', [meciuriController::class, 'store'])->middleware('auth');
Route::get('/admin-meciuri-edit/{id}', [meciuriController::class, 'edit'])->middleware('auth');
Route::post('/admin-meciuri-update', [meciuriController::class, 'update'])->middleware('auth');
Route::get('/admin-meciuri-delete/{id}', [meciuriController::class, 'destroy'])->middleware('auth');

Route::get('/admin-statistici-add/{meciID}', [statisticiSiEvenimenteController::class, 'createMS'])->middleware('auth');
Route::get('/admin-statistici-index/{meciID}', [statisticiSiEvenimenteController::class, 'indexAdminMS'])->middleware('auth');
Route::get('/admin-loturi-add/{meciID}/{echipaID}', [statisticiSiEvenimenteController::class, 'createLot'])->middleware('auth');
Route::get('/admin-goluri-assisturi-add/{meciID}/{echipaID}', [statisticiSiEvenimenteController::class, 'createGA'])->middleware('auth');
Route::get('/admin-cartonase-add/{meciID}/{echipaID}', [statisticiSiEvenimenteController::class, 'createCrt'])->middleware('auth');
Route::get('/admin-schimbari-add/{meciID}/{echipaID}', [statisticiSiEvenimenteController::class, 'createScb'])->middleware('auth');

Route::post('/admin-statistici-store', [statisticiSiEvenimenteController::class, 'storeMS'])->middleware('auth');
Route::post('/admin-loturi-store', [statisticiSiEvenimenteController::class, 'storeLot'])->middleware('auth');
Route::post('/admin-goluri-assisturi-store', [statisticiSiEvenimenteController::class, 'storeGA'])->middleware('auth');
Route::post('/admin-cartonase-store', [statisticiSiEvenimenteController::class, 'storeCrt'])->middleware('auth');
Route::post('/admin-schimbari-store', [statisticiSiEvenimenteController::class, 'storeScb'])->middleware('auth');

Route::get('/admin-statistici-delete/{id}', [statisticiSiEvenimenteController::class, 'destroyMS'])->middleware('auth');
Route::get('/admin-loturi-delete/{meciID}', [statisticiSiEvenimenteController::class, 'destroyLot'])->middleware('auth');
Route::get('/admin-goluri-assisturi-delete/{id}', [statisticiSiEvenimenteController::class, 'destroyGA'])->middleware('auth');
Route::get('/admin-cartonase-delete/{id}', [statisticiSiEvenimenteController::class, 'destroyCrt'])->middleware('auth');
Route::get('/admin-schimbari-delete/{id}', [statisticiSiEvenimenteController::class, 'destroyScb'])->middleware('auth');

Route::get('/admin-clasament-sezon-regulat', [ClasamentController::class, 'indexAdminSR'])->middleware('auth');
Route::get('/admin-clasament-play-off', [ClasamentController::class, 'indexAdminPOF'])->middleware('auth');
Route::get('/admin-clasament-play-out', [ClasamentController::class, 'indexAdminPOU'])->middleware('auth');

Route::get('/clasament-update/{faza}/{echipaID}/{coloana}/{update}', [ClasamentController::class, 'update'])->middleware('auth');
Route::get('/admin-clasament-refresh/{faza}', [ClasamentController::class, 'refresh'])->middleware('auth');

// Route::get('/admin-clasament-fill', [ClasamentController::class, 'storePO'])->middleware('auth');
// Route::get('/admin-tari-store', [jucatoriController::class, 'storeTari'])->middleware('auth');
// Route::get('/admin-admin-store', [adminController::class, 'store'])->middleware('auth');