<?php

namespace App\Http\Controllers\Employee;
use App\Http\Controllers\Controller;
use App\Services\EmployeeOrderService;
use Request;

class EmployeeOrderController extends Controller
{

    protected $employeeOrderService;

    public function __construct(EmployeeOrderService $employeeOrderService)
    {
        $this->employeeOrderService = $employeeOrderService;
    }

    /*
     * 按照条件获取员工列表
     * */
    public function getEmpOrderList()
    {
        $param = [
            "emp_id"    => Request::input('emp_id'),
            'cur_page'  => Request::input('cur_page', 1),
            'limit'     => Request::input('limit', 15)
        ];
        $rule = [
            "emp_id" => "integer",
            "cur_page"   => "integer",
            "limit"      => "integer"
        ];
        $this->validation($param, $rule);

        $data = $this->employeeOrderService->getEmpOrderList($param);
        return $data;
    }

    public function getOrderInfo()
    {
        $param = [
            "order_id"    => Request::input('order_id'),
            'from_type'   => Request::input('from_type')
        ];
        $rule = [
            "order_id" => "required",
            "from_type" => "required"
        ];
        $this->validation($param, $rule);

        $data = $this->employeeOrderService->getOrderInfo($param);
        return $data;
    }

    public function serverLog() {

        $param = [
            "order_id"    => Request::input('order_id'),
            'from_type'   => Request::input('from_type'),
            'remark'      => Request::input('remark')
        ];
        $rule = [
            "order_id"  => "required",
            "from_type" => "required",
            "remark"    => "required",
        ];
        $this->validation($param, $rule);


        $emp_data = Request::session()->get('emp');
        $param['emp_id'] = $emp_data['emp_id'];
        $param['emp_name'] = $emp_data['emp_name'];

        $data = $this->employeeOrderService->updateOrderRemark($param);
        return $data;
    }
}