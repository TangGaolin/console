<?php
namespace App\Repositories\Users;

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

    public function __construct(
        Users $users,
        Order $order,
        EmpOrder $empOrder,
        UserItems $userItems
    )
    {
        $this->usersModel      = $users;
        $this->orderModel      = $order;
        $this->empOrderModel   = $empOrder;
        $this->userItemsModel  = $userItems;
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
        $res         = $select->skip(($whereParam['cur_page']-1) * $whereParam['limit'])->take($whereParam['limit'])->get();

        return [
            'totalSize' => $count,
            'data'      => $res,
        ];
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
