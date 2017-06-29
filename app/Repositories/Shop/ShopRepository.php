<?php
namespace App\Repositories\Shop;

use App\Models\Shop;
use DB;

class ShopRepository implements ShopRepositoryInterface
{

    protected $shopModel;

    public function __construct(Shop $shop)
    {
        $this->shopModel= $shop;
    }

    public function getStoreList()
    {
        $result = $this->shopModel->select('shop_id', 'shop_name', 'shop_tel', 'city', 'address')
            ->where('shop_type', '=', 1)
            ->get();
        return $result->toArray();
    }

    public function updateStoreInfo($param)
    {
        return $this->shopModel->where(['shop_id' => $param['shop_id']])->update($param);
    }

    public function addStore($param)
    {
        return $this->shopModel->insert($param);
    }

    public function getShopInfo($shop_id)
    {
        $result = $this->shopModel->where('shop_id', '=', $shop_id)->first();
        return $result ? $result->toArray() : false;
    }


}
