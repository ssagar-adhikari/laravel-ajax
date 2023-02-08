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

Route::get('/', 'TodoController@index');
Route::get('/todos/{todo}/edit', 'TodoController@edit');
Route::post('/todos/store','TodoController@store');
Route::delete('/todos/delete/{todo}', 'TodoController@delete');
