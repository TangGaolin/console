<?php

namespace App\Http\Controllers\Employee;
use App\Http\Controllers\Controller;
use Request;

use App\Services\EmployeeService;
class EmployeeController extends Controller
{

    protected $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    /*
     * 按照条件获取员工列表
     * */
    public function getEmployeeList()
    {
        $param = [
            "emp_name_phone" => Request::input('emp_name_phone'),
            "shop_id"   => Request::input('shop_id'),
            "is_server" => Request::input('is_server'),
            "is_cashier"=> Request::input('is_cashier'),
            "is_admin"  => Request::input('is_admin'),
            'cur_page'  => Request::input('cur_page', 1),
            'limit'     => Request::input('limit', 15)
        ];
        $rule = [
            "emp_name_phone" => "nullable|string",
            "shop_id"    => "nullable|integer",
            "is_server"  => "nullable|integer",
            "is_cashier" => "nullable|integer",
            "is_admin"   => "nullable|integer",
            "cur_page"   => "integer",
            "limit"      => "integer"
        ];
        $this->validation($param, $rule);

        $data = $this->employeeService->getEmployeeList($param);
        return $this->success($data);
    }

    //获取到门店服务员工和跨店服务员工
    public function getServerEmpList()
    {
        $param = [
            "shop_id"   => Request::input('shop_id'),
            "is_server" => Request::input('is_server'),
            'cur_page'  => Request::input('cur_page', 1),
            'limit'     => Request::input('limit', 15)
        ];
        $rule = [
            "shop_id"    => "nullable|integer",
            "is_server"  => "nullable|integer",
            "cur_page"   => "integer",
            "limit"      => "integer"
        ];
        $this->validation($param, $rule);

        $data = $this->employeeService->getServerEmpList($param);
        return $this->success($data);
    }


    //添加员工
    public function addEmployee()
    {
        $param = [
            "emp_name" => Request::input("emp_name"),
            "phone_no" => Request::input("phone_no"),
            "is_server_all"      => Request::input("is_server_all"),
            "shop_id"  => Request::input("shop_id"),
            "job"      => Request::input("job"),
            "remark"   => Request::input("remark", "")
        ];
        $rule = [
            "emp_name" => "required|string",
            "phone_no" => "required|string",
            "is_server_all" => "required|integer",
            "shop_id"  => "required|integer",
            "job"      => "required|string",
            "remark"   => "string"
        ];

        $this->validation($param, $rule);
        return $this->employeeService->addEmployee($param);
    }

    //更新员工信息
    public function updateEmployee()
    {
        $param = [
            "emp_id"   => Request::input("emp_id"),
            "emp_name" => Request::input("emp_name"),
            "phone_no" => Request::input("phone_no"),
            "is_server_all"=> Request::input("is_server_all"),
            "shop_id"  => Request::input("shop_id"),
            "job"      => Request::input("job"),
            "remark"   => Request::input("remark", "")
        ];
        $rule = [
            "emp_id"   => "required|integer",
            "emp_name" => "required|string",
            "phone_no" => "required|string",
            "is_server_all" => "required|integer",
            "shop_id"  => "required|integer",
            "job"      => "required|string",
        ];

        $this->validation($param,$rule);

        return $this->employeeService->updateEmployee($param);
    }

    //删除员工
    public function removeEmployee()
    {
        $param = [
            "emp_id" => Request::input("emp_id")
        ];
        $rule = [
            "emp_id" => "required|integer"
        ];

        $this->validation($param,$rule);

        $param['is_server'] = 0;
        return $this->employeeService->updateEmployee($param);
    }

    //导入员工
    public function importEmployee()
    {
        $param = [
            'file'      => Request::file('file'),
            'shop_id'   => Request::input('shop_id')
        ];
        $rule = [
            'file'      => "required",
            'shop_id'   => "required|integer",
        ];
        $this->validation($param,$rule);
        $this->employeeService->importEmployee($param);

        return $this->success();
    }

    public function getEmployeeInfo()
    {
        $param = [
            "emp_id" => Request::input("emp_id")
        ];
        $rule = [
            "emp_id" => "required|integer"
        ];

        $this->validation($param, $rule);

        return $this->employeeService->getEmployeeInfo($param);
    }

}