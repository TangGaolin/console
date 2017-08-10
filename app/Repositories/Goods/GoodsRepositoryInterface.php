<?php
namespace App\Repositories\Goods;

interface GoodsRepositoryInterface
{
    public function getGoodsList($whereParam);
    public function getGoodInfo($whereParam);
    public function addGood($goodData);
    public function updateGood($goodData);

    public function addBrand($brandData);
    public function getBrandList($whereParam);
    public function updateBrand($brandData);
}
