<?php
namespace App\Repositories\Employee;

use App\Models\Employee;
use DB;
use phpDocumentor\Reflection\Types\Integer;

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

        //返回 0 也要判断
        isset($whereParam['is_server_all']) && $select = $select->where("is_server_all", "=", $whereParam["is_server_all"]);

        checkParam($whereParam,'shop_id') && $select = $select->where("shop_id", "=", $whereParam["shop_id"]);
        checkParam($whereParam,'is_server') && $select = $select->where("is_server", "=", $whereParam["is_server"]);
        checkParam($whereParam,'is_cashier') && $select = $select->where("is_cashier", "=", $whereParam["is_cashier"]);
        checkParam($whereParam,'is_admin') && $select = $select->where("is_admin", "=", $whereParam["is_admin"]);
        checkParam($whereParam,'phone_no') && $select = $select->where("phone_no", "=", $whereParam["phone_no"]);
        checkParam($whereParam,'emp_name') && $select = $select->where("emp_name", "like", $whereParam["emp_name"].'%');

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
            'data'      => $res ? $res->toArray() : []
        ];
    }

    public function getAccountLimit($whereParam)
    {
        $select = $this->employeeModel
            ->leftJoin('rbac_role_user', 'employee.emp_id', '=', 'rbac_role_user.aid')
            ->leftJoin('rbac_role', 'rbac_role.role_id', '=', 'rbac_role_user.role_id')
            ->where('employee.status', '1')->where('employee.is_admin', 1);

        checkParam($whereParam,'phone_no') && $select = $select->where("employee.phone_no", "=", $whereParam["phone_no"]);
        checkParam($whereParam,'emp_name') && $select = $select->where("employee.emp_name", "like", $whereParam["emp_name"].'%');

        $count = $select->count();

        $accountData = $select->skip(($whereParam['cur_page']-1) * $whereParam['limit'])->take($whereParam['limit'])
            ->get(['employee.emp_name', 'employee.phone_no', 'rbac_role.role_name', 'employee.emp_id', 'employee.is_super_admin', 'employee.status']);

        foreach ($accountData as $k => &$v) {
            if ($v['is_super_admin']) {
                $v['role_name'] = '超级管理员';
                $v['role_status'] = 1;
            }
        }
        return [
            'totalSize' => $count,
            'data'      => $accountData
        ];
    }

    public function getAdminById($emp_id)
    {
        $empInfo = $this->employeeModel
            ->leftJoin('rbac_role_user', 'employee.emp_id', '=', 'rbac_role_user.aid')
            ->leftJoin('rbac_role', 'rbac_role.role_id', '=', 'rbac_role_user.role_id')
            ->where('employee.emp_id', $emp_id)
            ->first(['employee.emp_name', 'employee.phone_no', 'rbac_role.role_name', 'employee.emp_id', 'employee.is_super_admin', 'employee.status']);
        if($empInfo) {
            $empInfo = $empInfo->toArray();
        }
        if ($empInfo['is_super_admin']) {
            $empInfo['role_name'] = '超级管理员';
        }
        return $empInfo;
    }

    public function getEmpDataByIds($emp_ids)
    {
        $select = $this->employeeModel->select('emp_id','emp_name','phone_no','sex','shop_id','job', "remark");
        $res = $select->whereIn('emp_id',$emp_ids)->get();
        return $res->toArray();
    }

    public function addEmployee($employeeData)
    {
        return $this->employeeModel->insertGetId($employeeData);
    }

    public function updateEmployee($emp_id, $employeeData)
    {
        return $this->employeeModel->where(['emp_id' => $emp_id])->update($employeeData);
    }

}
