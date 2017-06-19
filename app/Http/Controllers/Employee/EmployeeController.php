<?php

namespace App\Http\Controllers\Employee;
use App\Http\Controllers\Controller;
use Request;

use App\Services\EmployeeService;
class EmployeeController extends Controller
{

    protected $request;
    protected $employeeService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    public function getEmployeeList()
    {
        $param = [
            "emp_name_phone" => Request::input('emp_name_phone', ""),
            'cur_page' => Request::input('cur_page', 1),
            'limit' => Request::input('limit', 15)
        ];
        $rule = [
            "emp_name_phone" => "string",
            "cur_page" => "integer",
            "limit" => "integer"
        ];
        $this->validation($param, $rule);

        $data = $this->employeeService->getEmployeeList($param);
        return $this->success($data);
    }

    public function addEmployee()
    {
        $param = [
            "emp_name" => Request::input("emp_name"),
            "phone_no" => Request::input("phone_no"),
            "sex"      => Request::input("sex"),
            "shop_id"  => Request::input("shop_id"),
            "job"      => Request::input("job"),
            "remark"   => Request::input("remark", "")
        ];
        $rule = [
            "emp_name" => "required|string",
            "phone_no" => "required|string",
            "sex"      => "required|integer",
            "shop_id"  => "required|integer",
            "job"      => "required|string",
            "remark"   => "string"
        ];

        $this->validation($param, $rule);
        return $this->employeeService->addEmployee($param);

    }

    public function updateEmployee()
    {
        $param = [
            "emp_id" => Request::input("emp_id"),
            "emp_name" => Request::input("emp_name"),
            "phone_no" => Request::input("phone_no"),
            "sex"      => Request::input("sex"),
            "shop_id"  => Request::input("shop_id"),
            "job"      => Request::input("job"),
            "remark"   => Request::input("remark", "")
        ];
        $rule = [
            "emp_name" => "required|string",
            "phone_no" => "required|string",
            "sex"      => "required|integer",
            "shop_id"  => "required|integer",
            "job"      => "required|string",
            "remark"   => "string"
        ];

        $this->validation($param,$rule);

        $this->employeeService->updateEmployee($param);
        return $this->success();
    }

}