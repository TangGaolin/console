<?php

namespace App\Http\Controllers\Employee;
use App\Http\Controllers\Controller;
use Request;

use App\Services\EmployeeService;
class CashierController extends Controller
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

    // 添加收银账户
    public function addCashier()
    {
        $param = [
            "emp_name" => Request::input("emp_name"),
            "phone_no" => Request::input("phone_no"),
            "shop_id"  => Request::input("shop_id"),
        ];
        $rule = [
            "emp_name" => "required|string",
            "phone_no" => "required|string",
            "shop_id"  => "required|integer"
        ];

        $this->validation($param, $rule);
        return $this->employeeService->addCashier($param);
    }

    // 更新收银账户信息
    public function updateCashier()
    {
        $param = [
            "emp_name" => Request::input("emp_name"),
            "phone_no" => Request::input("phone_no"),
            "shop_id"  => Request::input("shop_id"),
        ];
        $rule = [
            "emp_name" => "required|string",
            "phone_no" => "required|string",
            "shop_id"  => "required|integer",
        ];

        $this->validation($param, $rule);
        return $this->employeeService->updateEmployee($param);
    }

    //移除收银账户
    public function removeCashier()
    {
        $param = [
            "emp_id" => Request::input("emp_id")
        ];
        $rule = [
            "emp_id" => "required|integer"
        ];

        $this->validation($param,$rule);
        $param['is_cashier'] = 0;
        return $this->employeeService->updateEmployee($param);
    }


}