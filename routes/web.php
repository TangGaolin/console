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
Route::post('/employee/updateEmployee', 'Employee\EmployeeController@updateEmployee');
Route::post('/employee/importEmployee', 'Employee\EmployeeController@importEmployee');
Route::post('/employee/removeEmployee', 'Employee\EmployeeController@removeEmployee');

Route::post('/employee/addCashier', 'Employee\CashierController@addCashier');
Route::post('/employee/updateCashier', 'Employee\CashierController@updateCashier');
Route::post('/employee/removeCashier', 'Employee\CashierController@removeCashier');


Route::post('/item/addItemType', 'Item\ItemController@addItemType');
Route::post('/item/getItemType', 'Item\ItemController@getItemType');
Route::post('/item/addItem', 'Item\ItemController@addItem');
Route::post('/item/getItemList', 'Item\ItemController@getItemList');
Route::post('/item/modifyItem', 'Item\ItemController@modifyItem');
Route::post('/item/modifyItemType', 'Item\ItemController@modifyItemType');


Route::post('/goods/addGood', 'Goods\GoodsController@addGood');
Route::post('/goods/getGoodsList', 'Goods\GoodsController@getGoodsList');
Route::post('/goods/updateGood', 'Goods\GoodsController@updateGood');


