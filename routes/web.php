<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AjaxController;

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
Route::get('hel', function () {
    return view('welcome');
});
Route::post('/status-update',[AjaxController::class,'dnd']);
Route::get('todo',[AjaxController::class,'showdata']);
Route::post('todo',[AjaxController::class,'senddata'])->name('ajaxRequest.post');
Route::post('/value-update',[AjaxController::class,'upval']);
Route::post('/entry-delete',[AjaxController::class,'del']);
Route::get('/load-page',[AjaxController::class,'sendview']);
Route::post('/prioritize',[AjaxController::class,'prioritize']);




