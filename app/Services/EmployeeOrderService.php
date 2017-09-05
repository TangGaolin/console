<?php
/**
 * Created by PhpStorm.
 * User: gaolintang
 * Date: 2017/5/23
 * Time: 下午3:27
 */
namespace App\Services;

use App\Repositories\Employee\EmpOrderRepositoryInterface;
use App\Repositories\Users\UsersAccountRepositoryInterface;


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

    public function getOrderInfo($param)
    {
        $orderRepository = app(UsersAccountRepositoryInterface::class);

        $order_info = [];
        if(0 == $param['from_type']) {
            $whereParam = [
                'order_id' => $param['order_id']
            ];
            $order_info = $orderRepository->getOrderInfo($whereParam);
        }

        if(1 == $param['from_type']) {
            $whereParam = [
                'use_order_id' => $param['order_id']
            ];
            $order_info = $orderRepository->getUseOrderInfo($whereParam);
        }

        return success($order_info);
    }




}