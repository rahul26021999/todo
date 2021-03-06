<?php

use Illuminate\Support\Facades\Route;

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
    // return view('welcome');
    return redirect('/home');
});

Auth::routes();

Route::get('create','TasksController@create');
Route::get('resolve','TasksController@closeTask');
Route::get('open','TasksController@openTask');
Route::get('delete','TasksController@delete');

Route::get('/home', 'HomeController@index')->name('home');
