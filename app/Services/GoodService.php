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
        //检查产品名称是否相同
        $res = $this->goodRepository->getGoodInfo(['good_name' => $param['good_name']]);
        if($res) {
            return fail(601, '该项目名称已经存在');
        }
        $this->goodRepository->addGood($goodData);
        return success();
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
        $this->goodRepository->addBrand($param);
        return success();
    }

    public function getBrandList($param)
    {
        $res = $this->goodRepository->getBrandList($param);
        return success($res);
    }

    public function updateBrand($param)
    {
        $this->goodRepository->updateBrand($param);
        return success();
    }



}