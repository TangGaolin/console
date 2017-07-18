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



Route::any('/getConfig', 'ConfigController@getConfig');

Route::post('/shop/login', 'Auth\ShopLoginController@login');  //店务系统登陆


Route::group(['middleware' => ['loginState']], function () {

    Route::post('/shop/logout', 'Auth\ShopLoginController@logout'); //店务系统退出

    Route::post('/shop/addUser', 'Users\UsersController@addUser');  //创建用户
    Route::post('/shop/searchUserList', 'Users\UsersController@getUserList'); //查询用户
    Route::post('/shop/typeUserList', 'Users\UsersController@typeUserList');  //获取类型的用户
    Route::post('/shop/getUserDetail', 'Users\UsersController@getUserDetail');  //获取用户详情

    Route::post('/shop/recharge', 'Users\UsersAccountController@recharge');  //充值
    Route::post('/shop/getOrderList', 'Users\UsersAccountController@getOrderList');  //获取用户购买记录

    Route::post('/shop/getEmployeeList', 'Employee\EmployeeController@getEmployeeList'); // 获取员工信息数据


    Route::post('/shop/getItemList', 'Item\ItemController@getItemList');  //获取服务数据

    Route::post('/shop/buyItems', 'Users\UsersAccountController@buyItems');  //购买服务

    Route::post('/shop/getGoodList', 'Goods\GoodsController@getGoodsList');  //获取产品列表
    Route::post('/shop/buyItem', 'Users\UsersController@buyItem');  //购买产品
    Route::post('/shop/repay', 'Users\UsersController@repay');  //用户还款
    Route::post('/shop/orderList', 'Users\UsersController@orderList');  //单据流水
    Route::post('/shop/orderRepeal', 'Users\UsersController@orderRepeal');  //用户还款
});

