<?php
/**
 * Created by PhpStorm.
 * User: gaolintang
 * Date: 2017/6/23
 * Time: 下午2:32
 */
namespace App\Services;


use App\Repositories\Goods\GoodsRepositoryInterface;

class GoodService {

    protected $goodRepository;

    public function __construct(GoodsRepositoryInterface $goodsRepository)
    {
        $this->goodRepository = $goodsRepository;
    }

    public function addGood($param)
    {
        $goodData = $param;
        $res = $this->goodRepository->addGood($goodData);
        return $this->success();
    }

    public function getGoodsList($param)
    {
        return $this->goodRepository->getGoodsList($param);
    }

    public function updateGood($param)
    {
        $goodData = $param;
        $res = $this->goodRepository->updateGood($goodData);
        return $this->success();
    }

    public function success()
    {
        return [
            'statusCode' => config('response_code.STATUSCODE_SUCCESS'),
            'msg'        => config('response_code.MSG_OK'),
            'success'    => true
        ];
    }



}