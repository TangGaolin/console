<?php

namespace App\Http\Controllers\Store;
use App\Http\Controllers\Controller;
use Request;

use App\Services\StoreDataService;
class StoreDataController extends Controller
{

    protected $storeDataService;

    public function __construct(StoreDataService $storeDataService)
    {
        $this->storeDataService = $storeDataService;
    }

    // 获取门店负债数据
    public function getStoreAllMoney()
    {
        $param = [
            'shop_id' => Request::input('shop_id')
        ];
        $rule = [
            "shop_id" => "required|numeric",
        ];

        $this->validation($param, $rule);
        return $this->storeDataService->getStoreAllMoney($param);
    }


}
