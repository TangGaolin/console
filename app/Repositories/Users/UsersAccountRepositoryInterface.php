<?php
namespace App\Repositories\Users;

interface UsersAccountRepositoryInterface
{
    public function getOrderList($param);
    public function recharge($param);
    public function buyItems($param);
    public function buyGoods();
    public function repayment();



}
