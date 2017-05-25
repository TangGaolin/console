<?php
/**
 * Created by PhpStorm.
 * User: gaolintang
 * Date: 2017/5/23
 * Time: 下午3:27
 */
namespace App\Services;

use App\Repositories\Shop\ShopRepositoryInterface;

Class StoreService {

    protected $responseCode;

    public function __construct()
    {
        $this->responseCode          = config('response_code');
    }

    public function getStoreList()
    {
        $shopRepository=  app(ShopRepositoryInterface::class);
        $storeList = $shopRepository->getStoreList();
        return $storeList;
    }


}