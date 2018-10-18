<?php

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

use Illuminate\Support\Facades\DB;
use App\Http\Controllers;
use App\Http\Controllers\Query;
use Illuminate\Support\Facades\Auth;

Route::get('/',function(){
  return view('welcome');
});

Route::get('/admin','AdminController@index');

Route::get('/settings','SettingsController@index');

Route::get('/settings/change/name','SettingsController@showNameForm');
Route::post('/settings/change/name','SettingsController@changeName')->name('change_name');

Route::get('/settings/change/password','SettingsController@showPasswordForm');
Route::post('/settings/change/password','SettingsController@changePassword')->name('change_password');

Route::get('/settings/change/2fa','SettingsController@show2faForm');
Route::post('/settings/change/2fa','SettingsController@change2fa')->name('change_2fa');
Route::post('/settings/change/complete-enable-2fa','SettingsController@customAddSecretKey')->name('insert_2fa_key');

// sysadmin
Route::get('/sysadmin/settings/{uid?}','SettingsController@index')->middleware('sysadmin');

Route::get('/sysadmin/settings/change/name/{uid?}','SettingsController@showNameForm')->name('change_name_form')->middleware('sysadmin');
Route::post('/sysadmin/settings/change/name/{uid?}','SettingsController@changeName')->name('change_name')->middleware('sysadmin');

Route::get('/sysadmin/settings/change/password/{uid?}','SettingsController@showPasswordForm')->name('change_password_form')->middleware('sysadmin');
Route::post('/sysadmin/settings/change/password/{uid?}','SettingsController@changePassword')->name('change_password')->middleware('sysadmin');

Route::get('/sysadmin/settings/change/2fa/{uid?}','SettingsController@show2faForm')->name('change_2fa_form')->middleware('sysadmin');
Route::post('/sysadmin/settings/change/2fa/{uid?}','SettingsController@change2fa')->name('change_2fa')->middleware('sysadmin');
Route::post('/sysadmin/settings/change/complete-enable-2fa/{uid?}','SettingsController@customAddSecretKey')->name('insert_2fa_key')->middleware('sysadmin');

Route::get('/sysadmin/settings/change/sysrole/{uid?}','SettingsController@showSysRole')->name('change_sys_role_form')->middleware('sysadmin');
Route::post('/sysadmin/settings/chhange/sysrole/{uid?}','SettingsController@changeSysRole')->name('change_sys_role')->middleware('sysadmin');

Route::get('/tb',function(){
  $query = new Query();
  $tickets = $query->retrieveAll('incident');
  return view('table',['tickets'=> $tickets]);
});

Route::get('/sysadmin','SysAdminController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/complete-registration', 'Auth\RegisterController@completeRegistration');

Route::post('/2fa','Auth\twofactorsController@AuthLogin')->name('2fa')->middleware('2fa');

Route::get('/files/edit/{id}/{filename?}','FileController@index')->name('editFile');

// Route::get('/filemanager/files/{id}/{filename}','RedirectController@getImage')->middleware('sysadmin');

Route::get('/403',function(){
  echo "YOU ARE NOT AUTHORISED TO DO THIS ACTION";
});