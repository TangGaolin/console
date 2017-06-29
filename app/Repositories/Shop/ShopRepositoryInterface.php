<?php
namespace App\Repositories\Shop;

interface ShopRepositoryInterface
{
    public function getStoreList();
    public function updateStoreInfo($param);
    public function addStore($param);
    public function getShopInfo($shop_id);
}
