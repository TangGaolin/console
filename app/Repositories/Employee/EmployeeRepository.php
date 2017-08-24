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
        $select = $this->employeeModel->select('emp_id','emp_name','phone_no', 'is_server_all','shop_id','job', "remark");
        $select = $select->where("status","=",1);

        checkParam($whereParam,'shop_id') && $select = $select->where("shop_id", "=", $whereParam["shop_id"]);
        checkParam($whereParam,'is_server') && $select = $select->where("is_server", "=", $whereParam["is_server"]);
        checkParam($whereParam,'is_cashier') && $select = $select->where("is_cashier", "=", $whereParam["is_cashier"]);
        checkParam($whereParam,'is_admin') && $select = $select->where("is_admin", "=", $whereParam["is_admin"]);
        checkParam($whereParam,'phone_no') && $select = $select->where("phone_no", "=", $whereParam["phone_no"]);
        checkParam($whereParam,'emp_name') && $select = $select->where("emp_name", "like", $whereParam["emp_name"].'%');

        $countSelect = $select;
        $count       = $countSelect->count();
        $res         = $select->skip(($whereParam['cur_page']-1) * $whereParam['limit'])->take($whereParam['limit'])->get();

        return [
            'totalSize' => $count,
            'data'      => $res,
        ];
    }

    public function getEmpDataByIds($emp_ids)
    {
        $select = $this->employeeModel->select('emp_id','emp_name','phone_no','sex','shop_id','job', "remark");
        $res = $select->whereIn('emp_id',$emp_ids)->get();
        return $res->toArray();
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
