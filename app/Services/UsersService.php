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
use App\Repositories\Users\UsersAccountRepositoryInterface;
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

        //获取门店信息
        $storeRepository = app(ShopRepositoryInterface::class);
        $storeList       = $storeRepository->getStoreList();
        $newStoreData = [];
        foreach ($storeList as $v) {
            $newStoreData[$v['shop_id']] = $v['shop_name'];
        }
        $data = $this->usersRepository->getUserList($param);

        //获取美疗师信息
        $emp_ids = array_column($data['data'],"emp_id");
        $empRepository = app(EmployeeRepositoryInterface::class);
        $emp_ids = array_unique($emp_ids);
        $emps = $empRepository->getEmpDataByIds($emp_ids);
        foreach ($emps as $emp){
            $convert_emps[$emp['emp_id']] = $emp['emp_name'];
        }

        foreach ($data['data'] as &$v) {
            $v["shop_name"] = $newStoreData[$v["shop_id"]] ?? "无指定门店";
            $v["emp_name"] = $convert_emps[$v["emp_id"]] ?? "无";
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

    public function getUserDetail($param)
    {
        $userInfo = [];
        if(isset($param['uid'])) {
            $userInfo = $this->usersRepository->getUserInfo(['uid' => $param['uid']]);
        }
        if(isset($param['phone_no']) && isset($param['shop_id'])) {
            $userInfo = $this->usersRepository->getUserInfo([
                'phone_no' => $param['phone_no'],
                'shop_id'  => $param['shop_id'],
            ]);
        }
        if(!empty($userInfo)) {
            //获取员工信息
            $empRepository = app(EmployeeRepositoryInterface::class);
            $emp_info = $empRepository->getEmployeeInfo(['emp_id' => $userInfo['emp_id']]);
            $userInfo['emp_name'] = $emp_info['emp_name'];
        }

        return [
            'statusCode' => config('response_code.STATUSCODE_SUCCESS'),
            'msg'        => config('response_code.MSG_OK'),
            'success'    => true,
            'data'       => $userInfo
        ];
    }

    public function getShopSideUsers($param)
    {

        // 获取预约顾客
        $data['res_user'] = [];

        // 获取生日提醒
        $data['birth_user'] = [];



        // 获取今日顾客
        $usersAccountRepository = app(UsersAccountRepositoryInterface::class);
        $whereParam['shop_id'] = $param['shop_id'];
        $whereParam['start_time'] = date('Y-m-d');
        $whereParam['end_time']   = $whereParam['start_time']  . " 23:59:59";
        $whereParam['limit']   = 1000;
        $useOrderData = $usersAccountRepository->getUseOrderList($whereParam);
        $orderData = $usersAccountRepository->getOrderList($whereParam);
        $u_ids1 = array_column($useOrderData['data'],'uid');
        $u_ids2 = array_column($orderData['data'],'uid');
        $u_ids = array_merge($u_ids1, $u_ids2);
        $useRepository = app(UsersRepositoryInterface::class);
        $users = $useRepository->getUserInfoByIds($u_ids);
        $data['today_user'] = [];
        foreach ($users as $user){
            $convert_users['uid'] = $user['uid'];
            $convert_users['user_name'] = $user['user_name'];
            $convert_users['phone_no'] = $user['phone_no'];
            $data['today_user'][] = $convert_users;
        }


        return [
            'statusCode' => config('response_code.STATUSCODE_SUCCESS'),
            'msg'        => config('response_code.MSG_OK'),
            'success'    => true,
            'data'       => $data
        ];
    }





}