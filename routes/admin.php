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
Route::post('/admin/login', 'Auth\AdminAuthController@login');

Route::group(['middleware' => ['AdminloginState']], function () {

    Route::post('/admin/logout', 'Auth\AdminAuthController@logout');  //管理员登录

    Route::post('/store/getStoreList', 'Store\StoreController@getStoreList');  //获取门店列表
    Route::post('/store/updateStoreInfo', 'Store\StoreController@updateStoreInfo'); //更新门店信息
    Route::post('/store/addStore', 'Store\StoreController@addStore');  //增加门店

    Route::post('/employee/getEmployeeList', 'Employee\EmployeeController@getEmployeeList'); //获取员工列表
    Route::post('/employee/addEmployee', 'Employee\EmployeeController@addEmployee');  //新增员工
    Route::post('/employee/updateEmployee', 'Employee\EmployeeController@updateEmployee'); //更新员工信息
    Route::post('/employee/importEmployee', 'Employee\EmployeeController@importEmployee');  //导入员工信息
    Route::post('/employee/removeEmployee', 'Employee\EmployeeController@removeEmployee');  //删除员工
    Route::post('/employee/getEmployeeInfo', 'Employee\EmployeeController@getEmployeeInfo');  //获取员工信息
    Route::post('/employee/getEmpDataView', 'DataViews\EmpDataController@getEmpDataView');  //获取用户数据接口
    Route::post('/employee/getEmpOrderList', 'Employee\EmployeeOrderController@getEmpOrderList');  //获取用户数据接口

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

    Route::post('/goods/addGood', 'Goods\GoodsController@addGood');  // 添加产品
    Route::post('/goods/getGoodsList', 'Goods\GoodsController@getGoodsList');  //获取产品列表
    Route::post('/goods/updateGood', 'Goods\GoodsController@updateGood');  // 更新产品信息

    Route::post('/users/getUserList', 'Users\UsersController@getUserList');  //获取会员列表
    Route::post('/users/updateUser', 'Users\UsersController@updateUser');  //更新会员信息
    Route::post('/users/getUserDetail', 'Users\UsersController@getUserDetail');  //获取用户详情
    Route::post('/users/getUserItemList', 'Users\UsersAccountController@getItemList');  //获取用户的服务数据
    Route::post('/users/getOrderList', 'Users\UsersAccountController@getOrderList');  //获取用户购买记录
    Route::post('/users/getUseOrderList', 'Users\UsersAccountController@getUseOrderList');  //耗卡记录
    Route::post('/users/addUser', 'Users\UsersController@addUser');  //创建用户
    Route::post('/users/importUser', 'Users\UsersController@importUser');  //导入用户

    Route::post('/order/getUseOrderList', 'Users\UsersAccountController@getUseOrderList');  //获取消耗记录
    Route::post('/order/getOrderList', 'Users\UsersAccountController@getOrderList');  //获取用户购买记录

    Route::post('/admin/resetPassword', 'Auth\ResetPasswordController@resetAdminPassword');  //修改密码接口


    Route::post('/storeData/getShopsDataView', 'DataViews\ShopDataController@getShopsDataView');  //获取门店总数据

    Route::post('/admin/addRole', 'Auth\AdminAuthController@addRole');  //添加角色
    Route::post('/admin/getRoleList', 'Auth\AdminAuthController@getRoleList');  //获取角色列表
    Route::post('/admin/roleAccess', 'Auth\AdminAuthController@roleAccess');  //获取权限节点
    Route::post('/admin/modifyRoleAccess', 'Auth\AdminAuthController@modifyRoleAccess');  //修改权限
    Route::post('/admin/disableRole', 'Auth\AdminAuthController@disableRole');  //删除角色

    Route::post('/admin/getNode', 'Auth\AdminAuthController@getNode');  //获取权限节点
    Route::post('/admin/openAccount', 'Auth\AdminAuthController@openAccount');  //创建管理员账号
    Route::post('/admin/getAccountList', 'Auth\AdminAuthController@getAccountList');  //创建管理员账号
    Route::post('/admin/disableAccount', 'Auth\AdminAuthController@disableAccount');  //删除账号


});
