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

Route::post('/emp/login', 'Auth\EmpLoginController@login');   //员工登录

Route::post('/emp/logout', 'Auth\EmpLoginController@logout');   //员工退出
Route::post('/emp/getUsers', 'Users\UsersController@getUserList');  //员工获取所属用户

Route::post('/emp/getEmpOrderList', 'Employee\EmployeeOrderController@getEmpOrderList');//获取员工单据流水接口
Route::post('/emp/getEmpDataView', 'DataViews\EmpDataController@getEmpDataView'); //获取员工数据接口

Route::post('/emp/resetPassword', 'Auth\ResetPasswordController@resetEmpPassword');  //员工修改密码接口

Route::post('/emp/resetPassword', 'Auth\ResetPasswordController@resetEmpPassword');  //员工修改密码接口

Route::post('/emp/getOrderInfo', 'Employee\EmployeeOrderController@getOrderInfo');   //获取单据详情


//Route::post('/emp/orderTime', 'Auth\LoginController@login'); //会员预约接口
//Route::post('/emp/serverLog', 'Auth\LoginController@login'); //服务记录





