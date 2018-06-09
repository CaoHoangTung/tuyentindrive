<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| c,,ơ;p/5e something great!
|
*/
// use App\Models\Main\User;
use Illuminate\Http\Request;
Route::get('/complete-registration', 'Auth\RegisterController@completeRegistration');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test',function(){
  // var_dump()
  var_dump(session()->get('name'));
  return("OK ".$_GET['pwd']);
});

// Route::post('/2fa/{one_time_password}', 'tfaController@authenticate')->name('2fa');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
