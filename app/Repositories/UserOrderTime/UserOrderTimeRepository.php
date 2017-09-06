<?php
namespace App\Repositories\UserOrderTime;

use App\Models\UserOrderTime;
use DB;

class UserOrderTimeRepository implements UserOrderTimeRepositoryInterface
{

    protected $userOrderTime;

    public function __construct(UserOrderTime $userOrderTime)
    {
        $this->userOrderTime = $userOrderTime;
    }

    public function addOrderTime($orderTimeData)
    {
        return $this->userOrderTime->insert($orderTimeData);
    }

    public function getOrderTime($whereParam)
    {
        $select = $this->userOrderTime;
        checkParam($whereParam,'uid') && $select = $select->where("uid", "=", $whereParam["uid"]);
        checkParam($whereParam,'start_time') && $select = $select->where("order_time", ">=", $whereParam["start_time"]);
        checkParam($whereParam,'end_time') && $select = $select->where("order_time", "<", $whereParam["end_time"]);
        checkParam($whereParam,'emp_id') && $select = $select->where("emp_id", "=", $whereParam["emp_id"]);

        $res = $select->get();
        return $res ? $res->toArray() : [];
    }

}
