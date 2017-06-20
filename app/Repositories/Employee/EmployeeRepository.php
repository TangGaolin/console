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
        $select = $select->where("is_admin","=",0);

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

    public function addEmployee($employeeData)
    {
        $res = $this->getEmployeeInfo(['phone_no' => $employeeData['phone_no']]);
        if($res) {
            return false;
        }
        return $this->employeeModel->insert($employeeData);
    }

    public function updateEmployee($employeeData)
    {
        $res = $this->getEmployeeInfo(['phone_no' => $employeeData['phone_no']]);
        if($res && (isset($employeeData['emp_id']) != $res["emp_id"])) {
            return false;
        }
        if(!isset($employeeData['emp_id']) && isset($employeeData['phone_no'])){
            return $this->employeeModel->where(['emp_phone' => $employeeData['emp_phone']])->update($employeeData);
        }
        return $this->employeeModel->where(['emp_id' => $employeeData['emp_id']])->update($employeeData);
    }

}
