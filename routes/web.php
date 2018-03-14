<?php
declare(strict_types=1);

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

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/test', function () {
        return view('test');
    });

    Route::resource('/persons', 'PersonController');
    Route::put('/persons/{person}/upload-avatar', 'PersonController@uploadAvatar')->name('persons.upload.avatar');

    Route::get('/parents/{person}', 'ParentController@create')->name('parents.create');
    Route::get('/siblings/{person}', 'SiblingController@create')->name('siblings.create');
    Route::get('/children/{person}', 'ChildController@create')->name('children.create');

    Route::put('/contacts/{contact}', 'ContactController@update')->name('contacts.update');
    Route::put('/biographical/{biographical}', 'BiographicalController@update')->name('biographical.update');
});