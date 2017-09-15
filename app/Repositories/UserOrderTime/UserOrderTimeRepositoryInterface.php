<?php
namespace App\Repositories\UserOrderTime;

interface UserOrderTimeRepositoryInterface
{
    public function addOrderTime($orderTimeData);
    public function getOrderTime($whereParam);
    public function updateOrderTime($orderTimeId, $updateData);

}
