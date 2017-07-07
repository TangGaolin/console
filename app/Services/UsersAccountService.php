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


Class UsersAccountService
{

    protected $usersRepository;
    public function __construct(UsersRepositoryInterface $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    public function recharge($param)
    {
        $payMoney =  $param['pay_cash'] +  $param['pay_card'] + $param['pay_mobile'];
        $orderId = date('YmdHis', time()) + mt_rand(100,999);
        //计算消费表数据
        $orderData = [
            "orderId"      => $orderId,
            "uid"          => $param['uid'],
            "charge_money" => $param['charge_money'],
            "pay_cash"     => $param['pay_cash'],
            "pay_card"     => $param['pay_card'],
            "pay_mobile"   => $param['pay_mobile'],
            "pay_money"    => $payMoney,
            "debt"         => $param['charge_money'] - $payMoney,
            "emp_info"     => json_encode($param['pay_emps'], JSON_UNESCAPED_UNICODE),
            "add_time"     => $param['add_time'],
        ];

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
            $empOrderData[] = $item;
        }

















    }










}