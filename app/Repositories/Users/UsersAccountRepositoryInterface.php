<?php
namespace App\Repositories\Users;

interface UsersAccountRepositoryInterface
{
    public function getOrderList($param);
    public function getOrderInfo($param);
    public function recharge($param);
    public function buyItems($param);
    public function getItemList($whereParam);
    public function getUserItemInfo($whereParam);
    public function useItems($param);
    public function getUseOrderList($param);

    public function buyGoods();
    public function repayment($param);




}
