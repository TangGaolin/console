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
        $select = $select->where("status","=",1);

        !empty($whereParam['is_server']) && $select = $select->where("is_server", "=", $whereParam["is_server"]);
        !empty($whereParam['is_cashier']) && $select = $select->where("is_cashier", "=", $whereParam["is_cashier"]);
        !empty($whereParam['is_admin']) && $select = $select->where("is_admin", "=", $whereParam["is_admin"]);
        !empty($whereParam['phone_no']) && $select = $select->where("phone_no", "=", $whereParam["phone_no"]);
        !empty($whereParam['emp_name']) && $select = $select->where("emp_name", "like", $whereParam["emp_name"].'%');

        $countSelect = $select;
        $count       = $countSelect->count();
        $res         = $select->skip(($whereParam['cur_page']-1) * $whereParam['limit'])->take($whereParam['limit'])->get();

        return [
            'totalSize' => $count,
            'data'      => $res,
        ];
    }

    public function addEmployee($employeeData)
    {
        $res = $this->getEmployeeInfo(['phone_no' => $employeeData['phone_no']]);
        if($res) {
            return $res;
        }
        return $this->employeeModel->insert($employeeData);
    }

    public function updateEmployee($emp_id, $employeeData)
    {
        return $this->employeeModel->where(['emp_id' => $emp_id])->update($employeeData);
    }

}
