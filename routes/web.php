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

Route::get('/', function () {
    return view('welcome');
});

Route::any('/getConfig', 'ConfigController@getConfig');
Route::post('/admin/login', 'Auth\LoginController@login');
Route::post('/admin/logout', 'Auth\LoginController@logout');
Route::post('/store/getStoreList', 'Store\StoreController@getStoreList');
Route::post('/store/updateStoreInfo', 'Store\StoreController@updateStoreInfo');
Route::post('/store/addStore', 'Store\StoreController@addStore');


Route::post('/employee/getEmployeeList', 'Employee\EmployeeController@getEmployeeList');
Route::post('/employee/addEmployee', 'Employee\EmployeeController@addEmployee');
