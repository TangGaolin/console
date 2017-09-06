<?php
/**
 * Created by PhpStorm.
 * User: gaolintang
 * Date: 2017/5/23
 * Time: 下午3:27
 */
namespace App\Services;

use App\Repositories\Employee\EmployeeRepositoryInterface;
use App\Repositories\Employee\EmpOrderRepositoryInterface;
use App\Repositories\UserOrderTime\UserOrderTimeRepositoryInterface;
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
        $empRepository = app(EmployeeRepositoryInterface::class);

        $empInfo = $empRepository->getEmployeeInfo(['emp_id' => $order_info['cashier_id']]);
        $order_info['cashier_name'] = $empInfo['emp_name'];


        return success($order_info);
    }

    public function updateOrderRemark($param)
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

        $order_info['remark'][] = [
            'remark' => $param['remark'],
            'emp_id' => $param['emp_id'],
            'emp_name' => $param['emp_name'],
            'add_time' => date('Y-m-d H:i:s')
        ];

        $updateData = [
            'remark' => json_encode($order_info['remark']),
        ];
        if(0 == $param['from_type']) {
            $whereParam = [
                'order_id' => $param['order_id'],
            ];
            $orderRepository->updateOrderRemark($whereParam, $updateData);
        }

        if(1 == $param['from_type']) {
            $whereParam = [
                'use_order_id' => $param['order_id'],
            ];
            $orderRepository->updateUseOrderRemark($whereParam, $updateData);
        }

        return success();
    }

    public function orderTime($param)
    {
        $orderTimeRepository = app(UserOrderTimeRepositoryInterface::class);
        $orderTimeRepository->addOrderTime($param);
        return success();
    }

    public function getOrderTime($whereParam)
    {
        $orderTimeRepository = app(UserOrderTimeRepositoryInterface::class);
        $res = $orderTimeRepository->getOrderTime($whereParam);
        return success($res);
    }




}