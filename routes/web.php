<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataBase;

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

Route::view('/', 'registation');
Route::view('/signin', 'login');
Route::get('registration', [DataBase::class, 'registration']);
Route::get('login', [DataBase::class, 'login']);
Route::get('/dashboard/{registration}',[DataBase::class, 'dashboard']);
Route::get('complaint/{name}/{registration}',[DataBase::class, 'form']);
Route::get('register/{name}',[DataBase::class, 'registercomplaint']);
Route::view('logout', 'login');
Route::get('delete/{registration}', [DataBase::class, 'deletecomplaint']);
Route::get('/admin', [DataBase::class, 'showadmin']);
Route::get('/list', [DataBase::class, 'showstudents']);
Route::get('{registration}/delete', [DataBase::class, 'deletestudent']);

