<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExcelFuncsController;
use App\Http\Controllers\JsonLiveController;
use App\Http\Controllers\SearchDbController;

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

//Route::get('/export', [ExcelFuncsController::class, 'export']); EXPORT FUNC - ONLY TO STUDY
Route::get('/', [ExcelFuncsController::class, 'homeView']);
Route::post('/importFunc', [ExcelFuncsController::class, 'import']);
Route::post('/loadJson',[JsonLiveController::class,'load']);
Route::post('/searchDB',[SearchDbController::class,'search']);