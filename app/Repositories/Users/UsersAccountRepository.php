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
            return $this->usersModel->where('uid','=',$param['order_data']['uid'])->update($updateData);
        };
        return DB::transaction($query);
    }

    public function getOrderList($whereParam)
    {

        $select = $this->orderModel;
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
        $res         = $select->skip(($whereParam['cur_page']-1) * $whereParam['limit'])->take($whereParam['limit'])->get();

        return [
            'totalSize' => $count,
            'data'      => $res,
        ];
    }

    public function buyItems($param)
    {
        $query = function () use ($param) {
            //插入订单表
            $this->orderModel->insert($param['order_data']);

            //插入员工明细表
            $this->empOrderModel->insert($param['emp_order_data']);

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
            //插入会员项目表
            return $this->userItemsModel->insert($param['user_items']);

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
        return $res ? $res->toArray() : false;
    }

    public function useItems($param)
    {
        $query = function () use ($param) {
            //插入员工明细表
            $this->empOrderModel->insert($param['empOrderDatas']);

            //账户卡进行更新
            foreach ($param['updateUserItemDatas'] as $userItemData) {
                $updateData['id'] = $userItemData['id'];
                $updateData['used_times'] = DB::raw('used_times+' . $userItemData['use_time']); // 更新次数

                // 更新金额
                $updateData['now_money'] = DB::raw('now_money-' . $userItemData['use_time'] * $userItemData['sold_price']);
                $updateData['status'] = $userItemData['status'];
                $this->userItemsModel->where('id', '=', $updateData['id'])->update($updateData);
            }
            //插入消耗表
            return $this->useOrderModel->insert($param['useOrderData']);
        };
        return DB::transaction($query);
    }


    public function buyGoods()
    {
        // TODO: Implement buyGoods() method.
    }

    public function repayment()
    {
        // TODO: Implement repayment() method.
    }


}
