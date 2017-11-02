<?php
namespace App\Repositories\Users;

interface UsersAccountRepositoryInterface
{
    public function getOrderList($param);
    public function getOrderInfo($param);
    public function recharge($param);
    public function chargeGood($param);
    public function buyItems($param);
    public function getItemList($whereParam);
    public function getUserItemInfo($whereParam);
    public function getAllItemMoney($whereParam);
    public function useItems($param);
    public function getUseOrderList($param);

    public function buyGoods($param);
    public function repayment($param);
    public function changeItems($param);

    public function getUseOrderInfo($whereParam);

    public function updateOrderRemark($whereParam, $updateData);
    public function updateUseOrderRemark($whereParam, $updateData);






}
