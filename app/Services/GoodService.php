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
        return [
            'statusCode' => config('response_code.STATUSCODE_SUCCESS'),
            'msg'        => config('response_code.MSG_OK'),
            'success'    => true
        ];
    }

    public function getGoodsList($param)
    {
        return $this->goodRepository->getGoodsList($param);
    }

    public function updateGood($param)
    {
        $goodData = $param;
        $res = $this->goodRepository->updateGood($goodData);
        return success();
    }

    //增加商品品牌
    public function addGoodBrand($param)
    {
        //检查是否对有重复名称
        $res = $this->goodRepository->getBrandList(['good_brand_name' => $param['good_brand_name']]);
        if($res) {
            return fail(602, "该品牌已经存在！");
        }
        $res = $this->goodRepository->addBrand($param);
        return success();
    }



}