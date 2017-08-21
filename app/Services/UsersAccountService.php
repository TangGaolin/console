<?php
/**
 * Created by PhpStorm.
 * User: gaolintang
 * Date: 2017/5/23
 * Time: 下午3:27
 */
namespace App\Services;

use App\Repositories\Employee\EmployeeRepositoryInterface;
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
        $orderId = date('YmdHis', time()) . mt_rand(100, 999);
        $payMoney =  $param['pay_cash'] +  $param['pay_card'] + $param['pay_mobile'];
        $debt = $param['charge_money'] - $payMoney;
        //计算消费表数据
        $orderData = [
            "order_id"     => $orderId,
            "order_type"   => 0, //充值订单类型为 0
            "uid"          => $param['uid'],
            "shop_id"      => $param['shop_id'],
            "worth_money"  => $param['charge_money'],
            "pay_cash"     => $param['pay_cash'],
            "pay_card"     => $param['pay_card'],
            "pay_mobile"   => $param['pay_mobile'],
            "pay_money"    => $payMoney,
            "debt"         => $debt,
            "status"       => $debt > 0 ? 1 : 0,
            "emp_info"     => json_encode($param['pay_emps'], JSON_UNESCAPED_UNICODE),
            "add_time"     => $param['add_time'],
            "cashier_id"   => $param['cashier_id'],
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
            $item['add_time']   = $param['add_time'];
            $empOrderData[]     = $item;
        }
        $res = $this->usersAccountRepository->recharge([
            'order_data' => $orderData,
            'emp_order_data' => $empOrderData,
        ]);

        return [
            'statusCode' => config('response_code.STATUSCODE_SUCCESS'),
            'msg'        => config('response_code.MSG_OK'),
            'success'    => true
        ];
    }

    public function chargeGoods($param)
    {
        $orderId = date('YmdHis', time()) . mt_rand(100,999);
        $payMoney =  $param['pay_cash'] +  $param['pay_card'] + $param['pay_mobile'];
        $debt = $param['charge_money'] - $payMoney; //计算欠款
        //计算消费表数据
        $orderData = [
            "order_id"     => $orderId,
            "order_type"   => 4, //产品卡充值订单类型为 4
            "uid"          => $param['uid'],
            "shop_id"      => $param['shop_id'],
            "order_info"   => $param['good_money'],  //产品价值
            "worth_money"  => $param['charge_money'],
            "pay_cash"     => $param['pay_cash'],
            "pay_card"     => $param['pay_card'],
            "pay_mobile"   => $param['pay_mobile'],
            "pay_money"    => $payMoney,
            "debt"         => $debt,
            "status"       => $debt > 0 ? 1 : 0,
            "emp_info"     => json_encode($param['pay_emps'], JSON_UNESCAPED_UNICODE),
            "add_time"     => $param['add_time'],
            "cashier_id"   => $param['cashier_id'],
        ];
        //计算员工业绩分成表
        $empOrderData = [];
        $user_info = $this->usersRepository->getUserInfo(['uid' => $param['uid']]);
        $order_desc = "产品卡充值" . '-' .$user_info['user_name'];
        foreach ($param['pay_emps'] as $v){
            $item['emp_id']     = $v['emp_id'];
            $item['order_desc'] = $order_desc;
            $item['yeji']       = $v['money'];
            $item['order_id']   = $orderId;
            $item['from_type']  = 0; //来自业绩表
            $item['add_time']   = $param['add_time'];
            $empOrderData[]     = $item;
        }
        $res = $this->usersAccountRepository->chargeGood([
            'order_data' => $orderData,
            'emp_order_data' => $empOrderData,
        ]);

        return [
            'statusCode' => config('response_code.STATUSCODE_SUCCESS'),
            'msg'        => config('response_code.MSG_OK'),
            'success'    => true
        ];
    }

    public function buyItems($param)
    {
        $orderId = date('YmdHis', time()) . mt_rand(100,999);
        $payMoney =  $param['pay_cash'] +  $param['pay_card'] + $param['pay_mobile'];
        $debt = $param['items_money'] - $payMoney - $param['pay_balance'];
        //计算消费表数据
        $orderData = [
            "order_id"     => $orderId,
            "order_type"   => 1, //购买服务类型为 1
            "uid"          => $param['uid'],
            "shop_id"      => $param['shop_id'],
            "worth_money"  => $param['items_money'],
            "order_info"   => json_encode($param['selected_items'], JSON_UNESCAPED_UNICODE),
            "pay_balance"  => $param['pay_balance'],
            "pay_cash"     => $param['pay_cash'],
            "pay_card"     => $param['pay_card'],
            "pay_mobile"   => $param['pay_mobile'],
            "pay_money"    => $payMoney,
            "debt"         => $debt,
            "status"       => $debt > 0 ? 1 : 0,
            "emp_info"     => json_encode($param['pay_emps'], JSON_UNESCAPED_UNICODE),
            "add_time"     => $param['add_time'],
            "cashier_id"   => $param['cashier_id']
        ];

        //计算会员项目表数据
        $userItems = [];
        foreach ($param['selected_items'] as $value) {
            $u_item['order_id']  = $orderId;
            $u_item['uid']       = $param['uid'];
            $u_item['item_id']   = $value['item_id'];
            $u_item['item_name'] = $value['item_name'];
            $u_item['price']     = $value['price'];
            $u_item['sold_price']= round($value['sold_money'] / $value['times'], 2);
            $u_item['discount']  = $value['discount'];
            $u_item['sold_money']= $value['sold_money'];
            $u_item['now_money'] = $value['sold_money'];
            $u_item['emp_fee']   = $value['emp_fee'];
            $u_item['times']     = $value['times'];
            $u_item['add_time']  = $param['add_time'];
            $userItems[] = $u_item;
        }

        //计算员工业绩分成表
        $empOrderData = [];
        $user_info = $this->usersRepository->getUserInfo(['uid' => $param['uid']]);
        $order_desc = "购买服务" . '-' .$user_info['user_name'];
        foreach ($param['pay_emps'] as $v){
            $item['emp_id']     = $v['emp_id'];
            $item['order_desc'] = $order_desc;
            $item['yeji']       = $v['money'];
            $item['order_id']   = $orderId;
            $item['from_type']  = 0; //来自业绩表
            $item['add_time']   = $param['add_time'];
            $empOrderData[]     = $item;
        }
        $res = $this->usersAccountRepository->buyItems([
            'order_data'     => $orderData,
            'emp_order_data' => $empOrderData,
            'user_items'     => $userItems
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
        if($param['select_date']){
            $param['start_time'] = $param['select_date'];
            $param['end_time']   = $param['select_date'] . " 23:59:59";
        }
        $orderList = $this->usersAccountRepository->getOrderList($param);

        //获取收银员信息
        $convert_cashiers = [];
        $convert_users = [];
        if($orderList['data']){
            $cashier_ids = array_column($orderList['data'],"cashier_id");
            $empRepository = app(EmployeeRepositoryInterface::class);
            $cashier_ids = array_unique($cashier_ids);
            $cashiers = $empRepository->getEmpDataByIds($cashier_ids);
            foreach ($cashiers as $cashier){
                $convert_cashiers[$cashier['emp_id']] = $cashier;
            }
            //若参数中没有uid条件参数，则就取用户信息
            if(!$param['uid']){
                $u_ids = array_column($orderList['data'],"uid");
                $u_ids = array_unique($u_ids);
                $useRepository = app(UsersRepositoryInterface::class);
                $users = $useRepository->getUserInfoByIds($u_ids);
                foreach ($users as $user){
                    $convert_users[$user['uid']] = $user;
                }
            }
        }

        //获取员工信息
        foreach ($orderList['data'] as &$order) {
            $order['cashier_name'] = $convert_cashiers[$order['cashier_id']]['emp_name'];
            if($convert_users){
                $order['user_name'] = $convert_users[$order['uid']]['user_name'];
            }
        }
        return [
            'statusCode' => config('response_code.STATUSCODE_SUCCESS'),
            'msg'        => config('response_code.MSG_OK'),
            'success'    => true,
            'data'       => $orderList
        ];
    }

    public function getItemList($param)
    {
        $orderList = $this->usersAccountRepository->getItemList($param);

        return [
            'statusCode' => config('response_code.STATUSCODE_SUCCESS'),
            'msg'        => config('response_code.MSG_OK'),
            'success'    => true,
            'data'       => $orderList
        ];
    }

    public  function useItems($param)
    {

        // 计算 useOrderData
        $useOrderId                   = date('YmdHis', time()) . mt_rand(1000, 9999);
        $useOrderData['use_order_id'] = $useOrderId;
        $useOrderData['uid']          = $param['uid'];
        $useOrderData['use_type']     = 0;  //0 为耗卡类型
        $useOrderData['shop_id']      = $param['shop_id'];
        $useOrderData['cashier_id']   = $param['cashier_id'];
        $useOrderData['items_info']   = json_encode($param['select_items'], JSON_UNESCAPED_UNICODE);
        $useOrderData['add_time']     = $param['add_time'];

        // 获取用户信息
        $user_info = $this->usersRepository->getUserInfo(['uid' => $param['uid']]);
        $order_desc = "耗卡" . '-' . $user_info['user_name'];
        $use_money = 0;
        $emps = [];

        // 计算员工消耗信息表
        $empOrderDatas = [];

        // 计算 user——items update 数据
        $updateUserItemDatas = [];

        foreach ($param['select_items'] as $select_item) {
            $use_money += $select_item['sold_price'] * $select_item['use_time']; //总消耗金额

            //耗卡次数验证
            $item = $this->usersAccountRepository->getUserItemInfo(['id' => $select_item['id']]);
            if($select_item['use_time'] + $item['used_times'] > $item['times']){
                return [
                    'statusCode' => config('response_code.STATUSCODE_SUCCESS'),
                    'msg'        => $item["item_name"] . "次数不正确，请验证",
                    'success'    => false
                ];
            }
            $updateUserItemData['status'] = 0;
            if($select_item['use_time'] + $item['used_times'] == $item['times']) {
                $updateUserItemData['status'] = 1;
            }

            $updateUserItemData['id']       = $select_item['id'];
            $updateUserItemData['use_time'] = $select_item['use_time'];
            $updateUserItemData['sold_price'] = $item['sold_price']; //用查出来的数据
            $updateUserItemDatas[]          = $updateUserItemData;


            foreach ($select_item['emps'] as $emp) {
                $empOrderData['emp_id']     = $emp['emp_id'];
                $empOrderData['order_desc'] = $order_desc;
                $empOrderData['fee']        = $emp['fee'];
                $empOrderData['xiaohao']    = $emp['xiaohao'];
                $empOrderData['order_id']   = $useOrderId;
                $empOrderData['from_type']  = 1;  //来源于消耗表
                $emps[] = $emp['emp_name'];
                $empOrderDatas[] = $empOrderData;
            }
        }

        $useOrderData['use_money'] = $use_money;
        $useOrderData['emps'] = implode(',', $emps);


        $res = $this->usersAccountRepository->useItems([
                'useOrderData'  => $useOrderData,
                'empOrderDatas' => $empOrderDatas,
                'updateUserItemDatas' => $updateUserItemDatas,
        ]);

        return [
            'statusCode' => config('response_code.STATUSCODE_SUCCESS'),
            'msg'        => config('response_code.MSG_OK'),
            'success'    => true
        ];
    }

    public function getUseOrderList($param)
    {
        if($param['select_date']){
            $param['start_time'] = $param['select_date'];
            $param['end_time']   = $param['select_date'] . " 23:59:59";
        }
        $orderList = $this->usersAccountRepository->getUseOrderList($param);

        $convert_cashiers = [];
        $convert_users = [];
        if($orderList['data']){
            $cashier_ids = array_column($orderList['data'],"cashier_id");
            $empRepository = app(EmployeeRepositoryInterface::class);
            $cashier_ids = array_unique($cashier_ids);
            $cashiers = $empRepository->getEmpDataByIds($cashier_ids);
            foreach ($cashiers as $cashier){
                $convert_cashiers[$cashier['emp_id']] = $cashier;
            }

            //若参数中没有uid条件参数，则就回去用户信息
            if(!$param['uid']){
                $u_ids = array_column($orderList['data'],"uid");
                $u_ids = array_unique($u_ids);
                $useRepository = app(UsersRepositoryInterface::class);
                $users = $useRepository->getUserInfoByIds($u_ids);
                foreach ($users as $user){
                    $convert_users[$user['uid']] = $user;
                }
            }
        }

        //获取员工信息
        foreach ($orderList['data'] as &$order) {
            $order['cashier_name'] = $convert_cashiers[$order['cashier_id']]['emp_name'];
            if($convert_users){
                $order['user_name'] = $convert_users[$order['uid']]['user_name'];
            }
        }

        return [
            'statusCode' => config('response_code.STATUSCODE_SUCCESS'),
            'msg'        => config('response_code.MSG_OK'),
            'success'    => true,
            'data'       => $orderList
        ];
    }

    public function repay($param)
    {
        //组合订单数据
        $orderId = date('YmdHis', time()) . mt_rand(100,999);
        $payMoney =  $param['pay_cash'] +  $param['pay_card'] + $param['pay_mobile'];

        $order_info = $this->usersAccountRepository->getOrderInfo(['order_id' => $param['order_id']]);

        $orderData = [
            "order_id"     => $orderId,
            "repay_order_id" => $param['order_id'],
            "order_type"   => 3, //还款订单类型为 3
            "uid"          => $param['uid'],
            "shop_id"      => $param['shop_id'],
            "worth_money"  => 0,  //还款价值金额为 0
            "pay_cash"     => $param['pay_cash'],
            "pay_card"     => $param['pay_card'],
            "pay_mobile"   => $param['pay_mobile'],
            "pay_money"    => $payMoney,
            "emp_info"     => json_encode($param['pay_emps'], JSON_UNESCAPED_UNICODE),
            "add_time"     => $param['add_time'],
            "cashier_id"   => $param['cashier_id'],
        ];
        //计算员工业绩分成表
        $empOrderData = [];
        $user_info = $this->usersRepository->getUserInfo(['uid' => $param['uid']]);
        $order_desc = "还款" . '-' .$user_info['user_name'];
        foreach ($param['pay_emps'] as $v){
            $item['emp_id']     = $v['emp_id'];
            $item['order_desc'] = $order_desc;
            $item['yeji']       = $v['money'];
            $item['order_id']   = $orderId;
            $item['from_type']  = 0; //来自业绩表
            $item['add_time']   = $param['add_time'];
            $empOrderData[]     = $item;
        }
        //更新账户欠款数据
        $updateData = [
            'uid'  => $param['uid'],
            'debt' => $payMoney,
            'order_id' => $param['order_id'],
            'status'   => $payMoney < $order_info['debt'] ? 1 : 10
        ];

        $res = $this->usersAccountRepository->repayment([
            'order_data' => $orderData,
            'emp_order_data' => $empOrderData,
            'update_data' => $updateData,
        ]);

        //更新数据
        return [
            'statusCode' => config('response_code.STATUSCODE_SUCCESS'),
            'msg'        => config('response_code.MSG_OK'),
            'success'    => true
        ];

    }

    public function buyGoods($param)
    {

        $orderId = date('YmdHis', time()) . mt_rand(100,999);
        $payMoney =  $param['pay_cash'] +  $param['pay_card'] + $param['pay_mobile'];
        $debt = $param['goods_money'] - $payMoney - $param['pay_balance'] - $param['use_good_money'];
        //计算消费表数据
        $orderData = [
            "order_id"     => $orderId,
            "order_type"   => 2, //购买产品类型为 2
            "uid"          => $param['uid'],
            "shop_id"      => $param['shop_id'],
            "worth_money"  => $param['goods_money'],
            "order_info"   => json_encode($param['selected_goods'], JSON_UNESCAPED_UNICODE),
            "pay_balance"  => $param['pay_balance'],
            "use_good_money"  => $param['use_good_money'],
            "pay_cash"     => $param['pay_cash'],
            "pay_card"     => $param['pay_card'],
            "pay_mobile"   => $param['pay_mobile'],
            "pay_money"    => $payMoney,
            "debt"         => $debt,
            "status"       => $debt > 0 ? 1 : 0,
            "emp_info"     => json_encode($param['pay_emps'], JSON_UNESCAPED_UNICODE),
            "add_time"     => $param['add_time'],
            "cashier_id"   => $param['cashier_id']
        ];

        //计算员工业绩分成表
        $empOrderData = [];
        $user_info = $this->usersRepository->getUserInfo(['uid' => $param['uid']]);
        $order_desc = "购买产品" . '-' .$user_info['user_name'];
        foreach ($param['pay_emps'] as $v){
            $item['emp_id']     = $v['emp_id'];
            $item['order_desc'] = $order_desc;
            $item['yeji']       = $v['money'];
            $item['order_id']   = $orderId;
            $item['from_type']  = 0; //来自业绩表
            $item['add_time']   = $param['add_time'];
            $empOrderData[]     = $item;
        }
        $res = $this->usersAccountRepository->buyGoods([
            'order_data'     => $orderData,
            'emp_order_data' => $empOrderData,
        ]);

        return success();
    }



    public function changeItems($param)
    {
        $orderId = date('YmdHis', time()) . mt_rand(100,999);

        // 若没有新项目则为退款，若有新项目为换购
        $orderType = $param['select_new_items'] ? 6 : 5;

        //计算插入订单数据
        $orderData = [
            "order_id" => $orderId,
            "order_type" => $orderType,
            "uid"   => $param['uid'],
        ];



        //更新老项目数据


        //更新新项目数据

        //




        return success();
    }










}