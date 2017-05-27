<?php
namespace App\Repositories\Employee;

use App\Models\Employee;
use DB;

class EmployeeRepository implements EmployeeRepositoryInterface
{

    protected $employeeModel;

    public function __construct(Employee $employee)
    {
        $this->employeeModel = $employee;
    }

    public function getEmployeeInfo($whereParam)
    {
        $result = $this->employeeModel->where($whereParam)->first();

        return $result ? $result->toArray() : false;
    }

    public function getEmployeeList($whereParam)
    {
        $select = $this->employeeModel->select('emp_id','emp_name','phone_no','sex','shop_id','job', "remark");

        !empty($param['phone_no']) && $select = $select->where("phone_no", "=", $whereParam["phone_no"]);
        !empty($param['emp_name']) && $select = $select->where("emp_name", "like", $whereParam["emp_name"].'%');

        $countSelect = $select;
        $count       = $countSelect->count();
        $res         = $select->skip(($whereParam['cur_page']-1) * $whereParam['limit'])->take($whereParam['limit'])->get();
        return [
            'totalSize' => $count,
            'data'      => $res,
        ];
    }

}
