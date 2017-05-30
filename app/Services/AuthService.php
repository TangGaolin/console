<?php
/**
 * Created by PhpStorm.
 * User: gaolintang
 * Date: 2017/5/23
 * Time: 下午3:27
 */
namespace App\Services;

use App\Repositories\Employee\EmployeeRepositoryInterface;

Class AuthService {

    protected $responseCode;

    public function __construct()
    {
        $this->responseCode          = config('response_code');
    }


    public function login($param)
    {
        $employee =  app(EmployeeRepositoryInterface::class);
        $res = $employee->getEmployeeInfo([
            'phone_no' => $param['user'],
            'password' => $param['password'],
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


}