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
use App\Repositories\UserOrderTime\UserOrderTimeRepositoryInterface;
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
        return success($data);
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

    public function importUser($param)
    {
        $data = Excel::load($param['file']->getPathName(), function ($reader) {
            return $reader;
        });
        $userData = $data->getSheet(0)->toArray();
        unset($userData[0]);
        unset($userData[1]);
        unset($userData[2]);
        $saveUserData = [];
        $error_flag = false;
        $insertData = [];
        foreach ($userData as $v) {
            $insertData['shop_id'] = $param['shop_id'];
            $insertData['user_name'] = trim($v[0]);
            $insertData['phone_no'] = trim($v[1]);

            if(!isPhoneNo($insertData['phone_no'])) {
                $error_flag = true;
                break;
            }
            $saveUserData[] = $insertData;
        }

        if($error_flag) {
            return fail(601,'表格数据错误:' . $insertData['user_name'] . ':' . $insertData['phone_no']);
        }

        $this->usersRepository->addUser($saveUserData);
        return success();
    }

    public function updateUser($param)
    {
        $userData = [];
        $uid = $param['uid'];
        foreach ($param as $key => $value){
            if(!is_null($value)){
                $userData[$key] = $value;
            }
        }
        $this->usersRepository->updateUser($uid, $userData);
        return success();
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

    public function getTodayUsers($param)
    {
        // 获取今日顾客
        $usersAccountRepository = app(UsersAccountRepositoryInterface::class);
        $whereParam['shop_id'] = $param['shop_id'];
        $whereParam['start_time'] = date('Y-m-d');
        $whereParam['end_time']   = $whereParam['start_time']  . " 23:59:59";
        $whereParam['limit']   = 1000;
        //今日消耗顾客
        $useOrderData = $usersAccountRepository->getUseOrderList($whereParam);
        //今日消耗顾客
        $orderData = $usersAccountRepository->getOrderList($whereParam);

        $use_ids   = array_column($useOrderData['data'],'uid');
        $order_ids = array_column($orderData['data'],'uid');
        $u_ids     = array_merge($use_ids, $order_ids);
        $u_ids     = array_unique($u_ids);
        $useRepository = app(UsersRepositoryInterface::class);
        $users = $useRepository->getUserInfoByIds($u_ids);
        $convert_users = [];
        foreach ($users as $v){
            $convert_users[$v['uid']] = $v;
        }
        $data = [];
        foreach ($u_ids as $uid){
            $tmpUser['uid'] = $uid;
            $tmpUser['phone_no'] = $convert_users[$uid]['phone_no'];
            $tmpUser['user_name'] = $convert_users[$uid]['user_name'];
            $data[] = $tmpUser;
        }
        return [
            'statusCode' => config('response_code.STATUSCODE_SUCCESS'),
            'msg'        => config('response_code.MSG_OK'),
            'success'    => true,
            'data'       => $data
        ];
    }

    public function checkUserOrderTime($param)
    {
        $userOrderTime = app(UserOrderTimeRepositoryInterface::class);
        $res = $userOrderTime->updateOrderTime($param['order_time_id'], ['status' => 1]); //确认顾客到店
        return success();
    }

    //获取订单数据
    public function getOrderUser($param)
    {
        $orderTimeRepository = app(UserOrderTimeRepositoryInterface::class);
        $resUser = $orderTimeRepository->getOrderTime([
            'shop_id' => $param['shop_id'],
            'status' => 0,
            'start_time' => date('Y-m-d H:i:s', time() - 12 * 60 * 60),
            'end_time' => date('Y-m-d H:i:s', time() + 36 * 60 * 60)
        ]);

        $res_ids   = array_column($resUser,'uid');
        $useRepository = app(UsersRepositoryInterface::class);

        $users = $useRepository->getUserInfoByIds($res_ids);
        $convert_users = [];
        foreach ($users as $v){
            $convert_users[$v['uid']] = $v;
        }
        $data = [];
        foreach ($resUser as $user){
            $tmpUser['user_name'] = $convert_users[$user['uid']]['user_name'];
            $tmpUser['phone_no'] = $convert_users[$user['uid']]['phone_no'];
            $tmpUser['uid'] = $user['uid'];
            $tmpUser['id'] = $user['id'];
            $tmpUser['emp_id'] = $user['emp_id'];
            $tmpUser['emp_name'] = $user['emp_name'];
            $tmpUser['order_time'] = $user['order_time'];
            $tmpUser['remark'] = $user['remark'];
            $data[] = $tmpUser;
        }
        return success($data);
    }




}