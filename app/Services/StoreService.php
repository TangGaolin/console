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
    protected $shopRepository;

    public function __construct(ShopRepositoryInterface $shopRepository)
    {
        $this->responseCode         = config('response_code');
        $this->shopRepository       = $shopRepository;
    }

    public function getStoreList()
    {
        $storeList = $this->shopRepository->getStoreList();
        return success($storeList);
    }

    public function updateStoreInfo($param)
    {
        if(isset($param['city'])){
            $param['province'] = $param['city'][0];
            $param['city'] = json_encode($param['city'],JSON_UNESCAPED_UNICODE);
        }

        $res = $this->shopRepository->updateStoreInfo($param);
        return success();
    }

    public function addStore($param)
    {
        if(isset($param['city'])){
            $param['province'] = $param['city'][0];
            $param['city'] = json_encode($param['city'],JSON_UNESCAPED_UNICODE);
        }
        $res = $this->shopRepository->addStore($param);
        return success();
    }


}