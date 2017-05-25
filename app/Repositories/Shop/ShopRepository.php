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
        $result = $this->shopModel->get();
        return $result->toArray();
    }

}
