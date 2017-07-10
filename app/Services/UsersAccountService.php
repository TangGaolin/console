<?php
/**
 * Created by PhpStorm.
 * User: gaolintang
 * Date: 2017/5/23
 * Time: 下午3:27
 */
namespace App\Services;

use App\Repositories\Shop\ShopRepositoryInterface;
use App\Repositories\Users\UsersAccountRepositoryInterface;
use App\Repositories\Users\UsersRepositoryInterface;


Class UsersAccountService
{

    protected $usersRepository;
    protected $usersAccountRepository;
    public function __construct(UsersRepositoryInterface $usersRepository, UsersAccountRepositoryInterface $usersAccountRepository)
    {
        $this->usersRepository = $usersRepository;
        $this->usersAccountRepository = $usersAccountRepository;
    }

    public function recharge($param)
    {
        $orderId = date('YmdHis', time()) . mt_rand(100,999);

        $payMoney =  $param['pay_cash'] +  $param['pay_card'] + $param['pay_mobile'];
        $debt = $param['charge_money'] - $payMoney;
        //计算消费表数据
        $orderData = [
            "order_id"      => $orderId,
            "uid"          => $param['uid'],
            "charge_money" => $param['charge_money'],
            "pay_cash"     => $param['pay_cash'],
            "pay_card"     => $param['pay_card'],
            "pay_mobile"   => $param['pay_mobile'],
            "pay_money"    => $payMoney,
            "debt"         => $debt,
            "status"       => $debt > 0 ? 1 : 0,
            "emp_info"     => json_encode($param['pay_emps'], JSON_UNESCAPED_UNICODE),
            "add_time"     => $param['add_time'],
        ];
        //计算员工业绩分成表
        $empOrderData = [];
        $user_info = $this->usersRepository->getUserInfo(['uid' => $param['uid']]);
        $order_desc = "充值" . '-' .$user_info['user_name'];
        foreach ($param['pay_emps'] as $v){
            $item['emp_id']     = $v['emp_id'];
            $item['order_desc'] = $order_desc;
            $item['yeji']       = $v['money'];
            $item['order_id']   = $orderId;
            $item['from_type']  = 0; //来自业绩表
            $item['add_time']   = $param['add_time']; //来自业绩表
            $empOrderData[]     = $item;
        }
        $res = $this->usersAccountRepository->recharge([
            'order_data' => $orderData,
            'emp_order_data' => $empOrderData,
        ]);
        //记录操作Log


        return [
            'statusCode' => config('response_code.STATUSCODE_SUCCESS'),
            'msg'        => config('response_code.MSG_OK'),
            'success'    => true
        ];
    }

    public function getOrderList($param)
    {
        $orderList = $this->usersAccountRepository->getOrderList($param);
        return [
            'statusCode' => config('response_code.STATUSCODE_SUCCESS'),
            'msg'        => config('response_code.MSG_OK'),
            'success'    => true,
            'data'       => $orderList
        ];
    }










}