<?php
/**
 * Created by PhpStorm.
 * User: gaolintang
 * Date: 2017/5/23
 * Time: 下午3:27
 */
namespace App\Services;


use App\Repositories\Users\UsersRepositoryInterface;
use Excel;


Class UsersService
{

    protected $usersRepository;
    public function __construct(UsersRepositoryInterface $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }


    public function addUser($param)
    {
        $userData = $param;
        $userInfo = $this->usersRepository->getUserInfo(['phone_no' => $userData['phone_no']]);
        if($userInfo){
            return [
                'statusCode' => config('response_code.STATUSCODE_USERERROR'),
                'msg' => "手机号码已经存在",
                'success' => false
            ];
        }
        $this->usersRepository->addUser($userData);
        return [
            'statusCode' => config('response_code.STATUSCODE_SUCCESS'),
            'msg' => config('response_code.MSG_OK'),
            'success' => true
        ];
    }





}