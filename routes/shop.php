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

Route::post('/shop/login', 'Auth\ShopLoginController@login');  //店务系统登陆

Route::group(['middleware' => ['loginState']], function () {

    Route::post('/shop/logout', 'Auth\ShopLoginController@logout'); //店务系统退出
    Route::post('/shop/addUser', 'Users\UsersController@addUser');  //创建用户
    Route::post('/shop/searchUserList', 'Users\UsersController@getUserList'); //查询用户
    Route::post('/shop/typeUserList', 'Users\UsersController@typeUserList');  //获取类型的用户 Not done
    Route::post('/shop/getServerEmpList', 'Employee\EmployeeController@getServerEmpList'); // 获取服务员工数据

    // 交易操作
    Route::post('/shop/recharge', 'Users\ShopActionController@recharge');  //充值
    Route::post('/shop/buyItems', 'Users\ShopActionController@buyItems');  //购买服务
    Route::post('/shop/useItems', 'Users\ShopActionController@useItems');  //耗卡
    Route::post('/shop/chargeGoods', 'Users\ShopActionController@chargeGoods');  //产品卡充值
    Route::post('/shop/repay', 'Users\ShopActionController@repay');  //用户还款
    Route::post('/shop/buyGoods', 'Users\ShopActionController@buyGoods');  //购买产品
    Route::post('/shop/changeItems', 'Users\ShopActionController@changeItems');  //退换操作接口

    // 获取交易数据
    Route::post('/shop/getUserDetail', 'Users\UsersController@getUserDetail');  //获取用户详情
    Route::post('/shop/getOrderList', 'Users\UsersAccountController@getOrderList');  //获取用户购买记录
    Route::post('/shop/getUserItemList', 'Users\UsersAccountController@getItemList');  //获取用户的服务数据
    Route::post('/shop/getUseOrderList', 'Users\UsersAccountController@getUseOrderList');  //获取消耗记录

    //全局数据
    Route::post('/shop/getShopDataView', 'DataViews\ShopDataController@getShopDataView');  //获取门店业绩消耗数据
    Route::post('/shop/getOrderUser', 'Users\UsersController@getOrderUser');  //获取预约数据接口
    Route::post('/shop/checkUserOrderTime', 'Users\UsersController@checkUserOrderTime');  //确认客人到店
    Route::post('/shop/getTodayUsers', 'Users\UsersController@getTodayUsers');  //获取今日来访用户

    //获取交易数据
    Route::post('/shop/getOrderInfo', 'Employee\EmployeeOrderController@getOrderInfo');   //获取单据详情

    //查询用户记录
    Route::post('/shop/getItemList', 'Item\ItemController@getItemList');  //获取当前服务项目
    Route::post('/shop/getGoodsList', 'Goods\GoodsController@getGoodsList');  //获取产品列表

    //基础功能
    Route::post('/shop/resetPassword', 'Auth\ResetPasswordController@resetCashierPassword');  //修改密码接口

    //更新会员信息
    Route::post('/shop/updateUser', 'Users\UsersController@updateUser');  //更新会员信息

    //更新会员信息
    Route::post('/shop/orderTime', 'Users\ShopActionController@orderTime');  //会员预约功能


});

