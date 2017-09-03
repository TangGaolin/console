<?php
/**
 * Created by PhpStorm.
 * User: gaolintang
 * Date: 2017/5/23
 * Time: 下午3:27
 */
namespace App\Services;

use App\Repositories\Employee\EmployeeRepositoryInterface;
use App\Repositories\Shop\ShopRepositoryInterface;

Class AuthService {

    protected $responseCode;

    public function __construct()
    {
        $this->responseCode          = config('response_code');
    }

    //后台管理员登录
    public function login($param)
    {
        $employee =  app(EmployeeRepositoryInterface::class);
        $res = $employee->getEmployeeInfo([
            'phone_no' => $param['user'],
            'password' => $param['password'],
            'is_admin' => 1,
            'status'    => 1,
        ]);

        //不存在，用户名和密码错误
        if(!$res){
            return [
                'statusCode' => $this->responseCode['STATUSCODE_PASSWDERROR'],
                'msg'  => $this->responseCode['MSG_PASSWDERROR'],
                'success' => false
            ];
        }

        unset($res['password']);
        return [
            'statusCode' => $this->responseCode['STATUSCODE_SUCCESS'],
            'msg'  => $this->responseCode['MSG_OK'],
            'success' => true,
            'data' => $res
        ];
    }

    //前台收银员登录
    public function cashierLogin($param)
    {
        $employee =  app(EmployeeRepositoryInterface::class);
        $res = $employee->getEmployeeInfo([
            'phone_no' => $param['user'],
            'password' => $param['password'],
            'is_cashier' => 1,
            'status' => 1,
        ]);
        //不存在，用户名和密码错误
        if(!$res){
            return [
                'statusCode' => $this->responseCode['STATUSCODE_PASSWDERROR'],
                'msg'  => $this->responseCode['MSG_PASSWDERROR'],
                'success' => false
            ];
        }

        $storeRepository = app(ShopRepositoryInterface::class);
        $res['shop_name'] = "";
        if(0 == $res['shop_id']) {
            $storeList = $storeRepository->getStoreList();
            foreach ($storeList as $shop){
                $store['shop_id'] = $shop['shop_id'];
                $store['shop_name'] = $shop['shop_name'];
                $res['shop_list'][] = $store;
            }
        }else{
            $storeInfo = $storeRepository->getShopInfo($res['shop_id']);
            $res['shop_name'] = $storeInfo['shop_name'];
        }

        unset($res['password']);
        return [
            'statusCode' => $this->responseCode['STATUSCODE_SUCCESS'],
            'msg'  => $this->responseCode['MSG_OK'],
            'success' => true,
            'data' => $res
        ];
    }

    //后台管理员登录
    public function empLogin($param)
    {
        $employee =  app(EmployeeRepositoryInterface::class);
        $res = $employee->getEmployeeInfo([
            'phone_no' => $param['user'],
            'password' => $param['password'],
            'is_server' => 1,
            'status'    => 1,
        ]);

        //不存在，用户名和密码错误
        if(!$res){
            return [
                'statusCode' => $this->responseCode['STATUSCODE_PASSWDERROR'],
                'msg'  => $this->responseCode['MSG_PASSWDERROR'],
                'success' => false
            ];
        }

        $storeRepository = app(ShopRepositoryInterface::class);
        $storeInfo = $storeRepository->getShopInfo($res['shop_id']);
        $res['shop_name'] = $storeInfo['shop_name'];

        unset($res['password']);
        return [
            'statusCode' => $this->responseCode['STATUSCODE_SUCCESS'],
            'msg'  => $this->responseCode['MSG_OK'],
            'success' => true,
            'data' => $res
        ];
    }


}