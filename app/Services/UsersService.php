<?php
/**
 * Created by PhpStorm.
 * User: gaolintang
 * Date: 2017/5/23
 * Time: 下午3:27
 */
namespace App\Services;

use App\Repositories\Shop\ShopRepositoryInterface;
use App\Repositories\Users\UsersRepositoryInterface;
use Excel;


Class UsersService
{

    protected $usersRepository;
    public function __construct(UsersRepositoryInterface $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }


    public function getUserList($param)
    {
        if (is_numeric($param['user_name_phone'])) {
            $param['phone_no'] = $param['user_name_phone'];
        } else {
            $param['user_name'] = $param['user_name_phone'];
        }

        $storeRepository = app(ShopRepositoryInterface::class);
        $storeList       = $storeRepository->getStoreList();
        $newStoreData = [];
        foreach ($storeList as $v) {
            $newStoreData[$v['shop_id']] = $v['shop_name'];
        }
        $data = $this->usersRepository->getUserList($param);

        foreach ($data['data'] as &$v) {
            $v["shop_name"] = $newStoreData[$v["shop_id"]] ?? "无指定门店";
        }
        return [
            'statusCode' => config('response_code.STATUSCODE_SUCCESS'),
            'msg' => config('response_code.MSG_OK'),
            'success' => true,
            'data' => $data
        ];
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