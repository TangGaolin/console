<?php
namespace App\Repositories\Employee;

interface EmployeeRepositoryInterface
{
    public function getEmployeeInfo($whereParam);
    public function getEmployeeList($whereParam);
    public function addEmployee($employeeData);
    public function updateEmployee($emp_id, $employeeData);
    public function getEmpDataByIds($emp_ids);
}
