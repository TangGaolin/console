<?php
/**
 * Created by PhpStorm.
 * User: gaolintang
 * Date: 2017/5/23
 * Time: 下午3:27
 */
namespace App\Services;

use App\Repositories\Employee\EmployeeRepositoryInterface;


Class EmployeeService {

    protected $responseCode;
    protected $employeeRepository;

    public function __construct(EmployeeRepositoryInterface $employeeRepository)
    {
        $this->responseCode         = config('response_code');
        $this->employeeRepository       = $employeeRepository;
    }

    public function getEmployeeList($param)
    {
        if (is_numeric($param['emp_name_phone'])) {
            $param['phone_no'] = $param['emp_name_phone'];
        } else {
            $param['emp_name'] = $param['emp_name_phone'];
        }

        return $this->employeeRepository->getEmployeeList($param);
    }



}