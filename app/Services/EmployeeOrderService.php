<?php
/**
 * Created by PhpStorm.
 * User: gaolintang
 * Date: 2017/5/23
 * Time: 下午3:27
 */
namespace App\Services;

use App\Repositories\Employee\EmpOrderRepositoryInterface;


Class EmployeeOrderService
{

    protected $employeeRepository;

    public function __construct(EmpOrderRepositoryInterface $empOrderRepository)
    {
        $this->employeeRepository = $empOrderRepository;
    }

    //获取单据列表
    public function getEmpOrderList($param)
    {
        $whereParam = $param;
        $data = $this->employeeRepository->getEmpOrderList($whereParam);
        return success($data);
    }


}