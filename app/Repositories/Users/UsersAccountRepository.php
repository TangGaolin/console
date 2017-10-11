<?php
namespace App\Repositories\Users;

use App\Models\UseOrder;
use App\Models\Users;
use App\Models\Order;
use App\Models\EmpOrder;
use App\Models\UserItems;
use DB;

class UsersAccountRepository implements UsersAccountRepositoryInterface
{

    protected $usersModel;
    protected $orderModel;
    protected $empOrderModel;
    protected $userItemsModel;
    protected $useOrderModel;

    public function __construct(
        Users $users,
        Order $order,
        EmpOrder $empOrder,
        UserItems $userItems,
        UseOrder $useOrder
    )
    {
        $this->usersModel      = $users;
        $this->orderModel      = $order;
        $this->empOrderModel   = $empOrder;
        $this->userItemsModel  = $userItems;
        $this->useOrderModel   = $useOrder;
    }

    //用户充值事物处理
    public function recharge($param)
    {
        $query = function () use ($param) {
            //插入订单表
            $this->orderModel->insert($param['order_data']);
            //插入员工明细表
            $this->empOrderModel->insert($param['emp_order_data']);
            //更新会员金额
            $updateData = [
                'balance'     => DB::raw('balance+' . $param['order_data']['worth_money']),
                'debt' => DB::raw('debt+' . $param['order_data']['debt']),
            ];

            //更新会员最近消费时间
            $leave_shop_time = [
                'leave_shop_time' => $param['order_data']['add_time']
            ];

            return $this->usersModel->where('uid','=',$param['order_data']['uid'])->update(array_merge($updateData, $leave_shop_time));
        };
        return DB::transaction($query);
    }

    // recharge good
    public function chargeGood($param)
    {
        $query = function () use ($param) {
            //插入订单表
            $this->orderModel->insert($param['order_data']);
            //插入员工明细表
            $this->empOrderModel->insert($param['emp_order_data']);
            //更新会员金额
            $updateData = [
                'good_money'     => DB::raw('good_money+' . $param['order_data']['order_info']),
                'debt' => DB::raw('debt+' . $param['order_data']['debt']),
            ];

            //更新会员最近消费时间
            $leave_shop_time = [
                'leave_shop_time' => $param['order_data']['add_time']
            ];
            return $this->usersModel->where('uid','=',$param['order_data']['uid'])->update(array_merge($updateData, $leave_shop_time));
        };
        return DB::transaction($query);
    }

    public function getOrderList($whereParam)
    {
        $select = $this->orderModel;

        if($this->checkValue($whereParam,'order_id')) {
            $select = $select->where("order_id", "=", $whereParam["order_id"]);
        }else{
            $this->checkValue($whereParam,'uid') && $select = $select->where("uid", "=", $whereParam["uid"]);
            $this->checkValue($whereParam,'start_time') &&$select = $select->where("add_time", ">=", $whereParam["start_time"]);
            $this->checkValue($whereParam,'end_time') && $select = $select->where("add_time", "<", $whereParam["end_time"]);
            $this->checkValue($whereParam,'shop_id') && $select = $select->where("shop_id", "=", $whereParam["shop_id"]);
            $this->checkValue($whereParam,'status') && $whereParam['status'] && $select = $select->where("status", "=", $whereParam["status"]);  //获取不同状态的订单
        }

        $countSelect = $select;
        $count       = $countSelect->count();

        if(!isset($whereParam['cur_page'])) {
            $whereParam['cur_page'] = 1;
        }

        if(!isset($whereParam['limit'])) {
            $whereParam['limit'] = 10;
        }

        $select = $select->orderBy('add_time', 'desc');
        $res         = $select->skip(($whereParam['cur_page']-1) * $whereParam['limit'])->take($whereParam['limit'])->get();

        return [
            'totalSize' => $count,
            'data'      => $res->toArray(),
        ];
    }

    protected function checkValue($array, $key)
    {
        return isset($array[$key]) && $array[$key];
    }


    public function getOrderInfo($whereParam)
    {
        $res = $this->orderModel->where($whereParam)->first();
        return $res ? $res->toArray() : [];
    }


    public function buyItems($param)
    {
        $query = function () use ($param) {

            //判断是否使用余额
            $updateData = [];
            if($param['order_data']['pay_balance'] > 0){
                $updateData['balance'] = DB::raw('balance-' . $param['order_data']['pay_balance']);
            }
            //判断是否有欠款
            if($param['order_data']['debt'] > 0){
                $updateData['debt'] = DB::raw('debt+' . $param['order_data']['debt']);
            }
            //更新会员金额
            if(!empty($updateData)){
                $this->usersModel->where('uid','=',$param['order_data']['uid'])->update($updateData);
            }
            //更新会员最近消费时间
            $leave_shop_time = [
                'leave_shop_time' => $param['order_data']['add_time']
            ];
            $this->usersModel->where('uid','=',$param['order_data']['uid'])->update($leave_shop_time);

            //插入会员项目表
            !empty($param['user_items']) && $this->userItemsModel->insert($param['user_items']);

            //散客 插入消耗表
            !empty($param['user_order_data']) && $this->useOrderModel->insert($param['user_order_data']);


            //插入员工明细表
            $this->empOrderModel->insert($param['emp_order_data']);

            //插入订单表
            return $this->orderModel->insert($param['order_data']);

        };
        return DB::transaction($query);
    }



    public function getItemList($whereParam)
    {
        $select = $this->userItemsModel;
        !empty($whereParam['uid']) && $select = $select->where("uid", "=", $whereParam["uid"]);

        $countSelect = $select;
        $count       = $countSelect->count();

        if(!isset($whereParam['cur_page'])) {
            $whereParam['cur_page'] = 1;
        }

        if(!isset($whereParam['limit'])) {
            $whereParam['limit'] = 10;
        }

        $select = $select->orderBy('add_time', 'desc');
        $res    = $select->skip(($whereParam['cur_page']-1) * $whereParam['limit'])->take($whereParam['limit'])->get();

        return [
            'totalSize' => $count,
            'data'      => $res,
        ];
    }


    public function getUserItemInfo($whereParam)
    {
        $res = $this->userItemsModel->where($whereParam)->first();
        return $res ? $res->toArray() : [];
    }

    public function useItems($param)
    {
        $query = function () use ($param) {
            //插入员工明细表
            $this->empOrderModel->insert($param['empOrderDatas']);

            //更新会员最近消费时间
            $leave_shop_time = [
                'leave_shop_time' => $param['useOrderData']['add_time']
            ];
            $this->usersModel->where('uid','=',$param['useOrderData']['uid'])->update($leave_shop_time);

            //账户卡进行更新
            foreach ($param['updateUserItemDatas'] as $userItemData) {
                $updateData['id'] = $userItemData['id'];
                $updateData['used_times'] = DB::raw('used_times+' . $userItemData['use_time']); // 更新次数

                // 更新金额
                $updateData['now_money'] = DB::raw('now_money-' . $userItemData['use_money']);
                $updateData['status'] = $userItemData['status'];
                $this->userItemsModel->where('id', '=', $updateData['id'])->update($updateData);
            }
            //插入消耗表
            return $this->useOrderModel->insert($param['useOrderData']);
        };
        return DB::transaction($query);
    }

    public function getUseOrderList($whereParam)
    {
        $select = $this->useOrderModel;

        if($this->checkValue($whereParam,'order_id')) {
            $select = $select->where("use_order_id", "=", $whereParam["order_id"]);
        }else{
            checkParam($whereParam, 'uid') && $select = $select->where("uid", "=", $whereParam["uid"]);
            checkParam($whereParam,'start_time') && $select = $select->where("add_time", ">=", $whereParam["start_time"]);
            checkParam($whereParam,'end_time') && $select = $select->where("add_time", "<", $whereParam["end_time"]);
            checkParam($whereParam,'shop_id') && $select = $select->where("shop_id", "=", $whereParam["shop_id"]);
        }

        $countSelect = $select;
        $count       = $countSelect->count();

        if(!isset($whereParam['cur_page'])) {
            $whereParam['cur_page'] = 1;
        }

        if(!isset($whereParam['limit'])) {
            $whereParam['limit'] = 10;
        }

        $select = $select->orderBy('add_time', 'desc');
        $res    = $select->skip(($whereParam['cur_page']-1) * $whereParam['limit'])->take($whereParam['limit'])->get();

        return [
            'totalSize' => $count,
            'data'      => $res->toArray(),
        ];
    }

    public function buyGoods($param)
    {
        $query = function () use ($param) {
            //插入订单表
            $this->orderModel->insert($param['order_data']);
            //判断是否使用余额
            $updateData = [];
            if($param['order_data']['pay_balance'] > 0){
                $updateData['balance'] = DB::raw('balance-' . $param['order_data']['pay_balance']);
            }

            if($param['order_data']['use_good_money'] > 0){
                $updateData['good_money'] = DB::raw('good_money-' . $param['order_data']['use_good_money']);
            }
            //判断是否有欠款
            if($param['order_data']['debt'] > 0){
                $updateData['debt'] = DB::raw('debt+' . $param['order_data']['debt']);
            }
            //更新会员金额
            if(!empty($updateData)){
                $this->usersModel->where('uid','=',$param['order_data']['uid'])->update($updateData);
            }

            //更新会员最近消费时间
            $leave_shop_time = [
                'leave_shop_time' => $param['order_data']['add_time']
            ];
            $this->usersModel->where('uid','=',$param['order_data']['uid'])->update($leave_shop_time);

            //插入员工明细表
            return $this->empOrderModel->insert($param['emp_order_data']);

        };
        return DB::transaction($query);
    }

    public function repayment($param)
    {
        $query = function () use ($param) {
            //插入订单表
            $this->orderModel->insert($param['order_data']);
            //插入员工明细表
            $this->empOrderModel->insert($param['emp_order_data']);
            //更新会员欠款金额
            $updateAccountData = [
                'debt' => DB::raw('debt-' . $param['update_data']['debt'])
            ];

            //更新会员最近消费时间
            $leave_shop_time = [
                'leave_shop_time' => $param['order_data']['add_time']
            ];
            $this->usersModel->where('uid','=',$param['update_data']['uid'])->update(array_merge($updateAccountData, $leave_shop_time));

            $updateOldOrderData = [
                'debt'   => DB::raw('debt-' . $param['update_data']['debt']),
                'status' => $param['update_data']['status']
            ];
            return $this->orderModel->where('order_id','=',$param['update_data']['order_id'])->update($updateOldOrderData);
        };
        return DB::transaction($query);
    }

    public function changeItems($param)
    {
        $query = function () use ($param) {

            // 判断是否使用余额
            $updateData = [];
            if($param['order_data']['pay_balance'] > 0){
                $updateData['balance'] = DB::raw('balance-' . $param['order_data']['pay_balance']);
            }

            // 判断是否有欠款
            if($param['order_data']['debt'] > 0){
                $updateData['debt'] = DB::raw('debt+' . $param['order_data']['debt']);
            }
            // 更新会员金额
            if(!empty($updateData)){
                $this->usersModel->where('uid','=',$param['order_daadd_timeta']['uid'])->update($updateData);
            }
            //更新会员最近消费时间
            $leave_shop_time = [
                'leave_shop_time' => $param['order_data']['add_time']
            ];
            $this->usersModel->where('uid','=',$param['order_data']['uid'])->update($leave_shop_time);

            // 账户卡进行更新
            foreach ($param['update_item_data'] as $userItemData) {
                $updateData['id'] = $userItemData['id'];
                $updateData['used_times'] = DB::raw('used_times+' . $userItemData['use_time']); //更新次数
                // 更新金额
                $updateData['now_money'] = DB::raw('now_money-' . $userItemData['use_money']);
                $updateData['status'] = $userItemData['status'];
                $this->userItemsModel->where('id', '=', $updateData['id'])->update($updateData);
            }

            // 新增项目卡
            if(!empty($param['new_item_data'])) {
                $this->userItemsModel->insert($param['new_item_data']);
            }

            // 插入员工明细表
            $this->empOrderModel->insert($param['emp_order_data']);

            // 插入订单表
            return $this->orderModel->insert($param['order_data']);

        };
        return DB::transaction($query);
    }

    public function getUseOrderInfo($whereParam)
    {
        $res = $this->useOrderModel->where($whereParam)->first();
        return $res ? $res->toArray() : [];
    }

    public function updateOrderRemark($whereParam, $updateData)
    {
        return $this->orderModel->where($whereParam)->update($updateData);
    }

    public function updateUseOrderRemark($whereParam, $updateData)
    {
        return $this->useOrderModel->where($whereParam)->update($updateData);
    }


}
