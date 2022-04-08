<?php

use App\Http\Controllers\Admin\HomeController;
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

// Route::get('/', function () {
//     return view('welcome');
// }); ->rimuovo

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home'); -> rimuovo

//queste rotte accessibili solo a chi passa autenticazione
Route::middleware('auth')
//i loro controller si trovano nel namespace seguente
->namespace('Admin')
// il NOME delle rotte comincia per admin.
->name('admin.')
// l'uri delle rotte comincia per /admin/
->prefix('admin')
//tutte le rotte di questo tipo vengono quindi raggruppate
->group(function(){
    // ad esempio qui di seguito la rotta / sarebbe uguale a /admin/. Questa risponde al controller index di HomeController
    Route::get('/', 'HomeController@index')->name('home');

    //rotte post
    Route::resource('posts', 'PostController');

    // rotte tag
    Route::resource('tag', 'TagController');

});

// rotta di fallback su guest.home, accetto any dove per any intendo qualsiasi rotta ".*"
Route::get('{any?}', function(){
    return view('guest.home');
})->where('any', '.*');