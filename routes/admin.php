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



Route::any('/', function () {
    return redirect('/index.html', '301');
});

Route::any('/getConfig', 'ConfigController@getConfig');
Route::post('/admin/login', 'Auth\LoginController@login');

Route::group(['middleware' => ['AdminloginState']], function () {

    Route::post('/admin/logout', 'Auth\LoginController@logout');  //管理员登录
    Route::post('/store/getStoreList', 'Store\StoreController@getStoreList');  //获取门店列表
    Route::post('/store/updateStoreInfo', 'Store\StoreController@updateStoreInfo'); //更新门店信息
    Route::post('/store/addStore', 'Store\StoreController@addStore');  //增加门店

    Route::post('/employee/getEmployeeList', 'Employee\EmployeeController@getEmployeeList'); // 获取门店列表
    Route::post('/employee/addEmployee', 'Employee\EmployeeController@addEmployee');  //新增员工
    Route::post('/employee/updateEmployee', 'Employee\EmployeeController@updateEmployee'); //更新员工信息
    Route::post('/employee/importEmployee', 'Employee\EmployeeController@importEmployee');  //导入员工信息
    Route::post('/employee/removeEmployee', 'Employee\EmployeeController@removeEmployee');  //删除员工

    Route::post('/employee/addCashier', 'Employee\CashierController@addCashier');  // 增加收银账号
    Route::post('/employee/updateCashier', 'Employee\CashierController@updateCashier');  //更新收银员信息
    Route::post('/employee/removeCashier', 'Employee\CashierController@removeCashier');  //删除收银员

    Route::post('/item/addItemType', 'Item\ItemController@addItemType');  //增加疗程类别
    Route::post('/item/getItemType', 'Item\ItemController@getItemType');  //获取疗程项目类别
    Route::post('/item/modifyItemType', 'Item\ItemController@modifyItemType'); //修改项目类别

    Route::post('/item/addItem', 'Item\ItemController@addItem');  //增加项目
    Route::post('/item/getItemList', 'Item\ItemController@getItemList'); //增加项目列表
    Route::post('/item/modifyItem', 'Item\ItemController@modifyItem'); //修改项目

    Route::post('/goods/addGoodBrand', 'Goods\GoodBrandController@addGoodBrand'); //增加商品品牌
    Route::post('/goods/getBrandList', 'Goods\GoodBrandController@getBrandList'); //获取品牌列表
    Route::post('/goods/updateBrand', 'Goods\GoodBrandController@updateBrand');   //更新品牌

    Route::post('/goods/addGood', 'Goods\GoodsController@addGood');
    Route::post('/goods/getGoodsList', 'Goods\GoodsController@getGoodsList');
    Route::post('/goods/updateGood', 'Goods\GoodsController@updateGood');

    Route::post('/users/addUser', 'Users\UsersController@addUser');
    Route::post('/users/getUserList', 'Users\UsersController@getUserList');

});
