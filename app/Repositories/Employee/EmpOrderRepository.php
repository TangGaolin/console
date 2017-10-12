<?php
namespace App\Repositories\Employee;

use App\Models\Employee;
use App\Models\EmpOrder;
use DB;

class EmpOrderRepository implements EmpOrderRepositoryInterface
{

    protected $empOrder;

    public function __construct(EmpOrder $empOrder)
    {
        $this->empOrder = $empOrder;
    }

    public function getEmpOrderList($whereParam)
    {

        $select = $this->empOrder;
        checkParam($whereParam,'emp_id') && $select = $select->where("emp_id", "=", $whereParam["emp_id"]);
        checkParam($whereParam,'shop_id') && $select = $select->where("shop_id", "=", $whereParam["shop_id"]);
        checkParam($whereParam,'start_time') &&$select = $select->where("add_time", ">=", $whereParam["start_time"]);
        checkParam($whereParam,'end_time') && $select = $select->where("add_time", "<", $whereParam["end_time"]);

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


}
