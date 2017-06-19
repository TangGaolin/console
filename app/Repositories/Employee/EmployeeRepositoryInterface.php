<?php
namespace App\Repositories\Employee;

interface EmployeeRepositoryInterface
{
    public function getEmployeeInfo($phone_no);
    public function getEmployeeList($whereParam);
    public function addEmployee($employeeData);
    public function updateEmployee($employeeData);
}
