<?php
namespace App\Repositories\Goods;

interface GoodsRepositoryInterface
{
    public function getGoodsList($whereParam);
    public function addGood($goodData);
    public function updateGood($goodData);
}
