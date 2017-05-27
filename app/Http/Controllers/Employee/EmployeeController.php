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
            "emp_name_phone"  => Request::input('emp_name_phone', ""),
            'cur_page'        => Request::input('cur_page', 1),
            'limit'           => Request::input('limit', 15)
        ];
        $rule = [
            "emp_name_phone"  => "string",
            "cur_page"        => "integer",
            "limit"           => "integer"
        ];
        $this->validation($param, $rule);

        $data = $this->employeeService->getEmployeeList($param);
        return $this->success($data);
    }


}
