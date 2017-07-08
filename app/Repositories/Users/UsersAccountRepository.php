<?php
namespace App\Repositories\Users;

use App\Models\Users;
use App\Models\Order;
use App\Models\EmpOrder;
use DB;

class UsersAccountRepository implements UsersAccountRepositoryInterface
{

    protected $usersModel;
    protected $orderModel;
    protected $empOrderModel;

    public function __construct(
        Users $users,
        Order $order,
        EmpOrder $empOrder
    )
    {
        $this->usersModel      = $users;
        $this->orderModel      = $order;
        $this->empOrderModel   = $empOrder;
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
                'balance'     => DB::raw('balance+' . $param['order_data']['charge_money']),
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

        $res         = $select->skip(($whereParam['cur_page']-1) * $whereParam['limit'])->take($whereParam['limit'])->get();

        return [
            'totalSize' => $count,
            'data'      => $res,
        ];
    }

    public function buyItem()
    {
        // TODO: Implement buyItem() method.
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
