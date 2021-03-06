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

use App\Employer;
use App\Englishlevel;
use App\Experience;
use App\Language;
use App\Typeemployement;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});
//Route::get('/test', function () {
//    $user = \App\Employer::all();
//    return view('welcome', compact('user'));
//});

/*=======================Авторизация==================================*/

/*=======================Поиск работы==================================*/
Route::group(['prefix' => 'aspirant', 'namespace' => 'Aspirant',
    'middleware' => ['auth']], function () {
    Route::get('/', function () {//newdiplom/aspirant
        $ids = Language::idName();
        $experience = Experience::idName();
        $eng = Englishlevel::idName();
        $t_empl = Typeemployement::idName();
        return view('aspirants.aspirant', compact('ids', 'experience', 'eng', 't_empl'));
    });

});
/*=====================================================================*/

/*=======================Поиск сторудника==============================*/
//Еще не реализован, для работодателя

//Route::group(['prefix' => 'employer', 'namespace' => '',
////    'middleware' => ['auth']], function () {
////    //Route::resource('','EmployerController');
////    Route::resource('','EmployerController@');
////
////}
////);

Route::resource('employer', 'EmployerController');
Route::get('employer/{employer}', 'EmployerController@show');


Route::get('/home', 'HomeController@index')->name('home');

/*==============================Оферы==================================*/
//Route::get('/offers', 'Offers\OfferController@offer');
Route::group(['prefix' => 'offers', 'namespace' => 'Оffers',], function () {
    Route::get('/', function () {//newdiplom/aspirant
        return view('jobs.offers');//, compact('r'));
    });
}
);
/*=====================================================================*/

/*==================Админ панель=======================================*/
Route::get('admin', 'Admin\AdminController@index');
Route::resource('admin/roles', 'Admin\RolesController');
Route::resource('admin/permissions', 'Admin\PermissionsController');
Route::resource('admin/users', 'Admin\UsersController');
Route::resource('admin/pages', 'Admin\PagesController');
Route::resource('admin/activitylogs', 'Admin\ActivityLogsController')->only([
    'index', 'show', 'destroy'
]);
Route::resource('admin/settings', 'Admin\SettingsController');
Route::get('admin/generator', ['uses' => '\Appzcoder\LaravelAdmin\Controllers\ProcessController@getGenerator']);
Route::post('admin/generator', ['uses' => '\Appzcoder\LaravelAdmin\Controllers\ProcessController@postGenerator']);
/*=====================================================================*/

Auth::routes();

