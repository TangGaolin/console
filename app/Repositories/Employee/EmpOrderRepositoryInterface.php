<?php
namespace App\Repositories\Employee;

interface EmpOrderRepositoryInterface
{
    public function getEmpOrderList($whereParam);
}
