<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExcelFuncsController;

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

Route::get('/', function () {
    return view('welcome');
});
//Route::get('/export', [ExcelFuncsController::class, 'export']); EXPORT FUNC - ONLY TO STUDY
Route::get('/importExportView', [ExcelFuncsController::class, 'importExportView']);
Route::post('/import', [ExcelFuncsController::class, 'import']);