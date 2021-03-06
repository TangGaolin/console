<?php
namespace App\Repositories\Goods;

use App\Models\Goods;
use App\Models\GoodBrand;
use DB;

class GoodsRepository implements GoodsRepositoryInterface
{

    protected $goods;
    protected $brandModel;

    public function __construct(Goods $goods,GoodBrand $goodBrand)
    {
        $this->goods = $goods;
        $this->brandModel = $goodBrand;
    }

    public function getGoodsList($whereParam)
    {
        $select = $this->goods->select();
        checkParam($whereParam,'good_name') && $select = $select->where("good_name", "like", $whereParam["good_name"].'%');
        checkParam($whereParam,'pinyin') && $select = $select->where("pinyin", "like", $whereParam["pinyin"].'%');
        checkParam($whereParam,'brand') && $select = $select->where("brand", $whereParam["brand"]);
        $countSelect = $select;
        $count       = $countSelect->count();
        $res         = $select->skip(($whereParam['cur_page']-1) * $whereParam['limit'])->take($whereParam['limit'])->get();
        return [
            'totalSize' => $count,
            'data'      => $res,
        ];
    }

    public function getGoodInfo($whereParam)
    {
        $select = $this->goods->select();
        checkParam($whereParam,'good_id') && $select = $select->where("good_id", $whereParam['good_id']);
        checkParam($whereParam,'good_name') && $select = $select->where("good_name", $whereParam['good_name']);
        $res = $select->first();
        return $res ? $res->toArray() : [];
    }

    public function addGood($goodData)
    {
        return $this->goods->insert($goodData);
    }

    public function updateGood($goodData)
    {
        return $this->goods->where('good_id', '=', $goodData['good_id'])->update($goodData);
    }

    public function addBrand($brandData)
    {
        return $this->brandModel->insert($brandData);
    }

    public function getBrandList($whereParam)
    {
        checkParam($whereParam, 'status') && $this->brandModel = $this->brandModel->where('status',$whereParam['status']);
        checkParam($whereParam, 'good_brand_name') && $this->brandModel = $this->brandModel->where('good_brand_name',$whereParam['good_brand_name']);
        $res = $this->brandModel->select('good_brand_id','good_brand_name','status','admin_id')->get();
        return $res->toArray();
    }

    public function updateBrand($brandData)
    {
        return $this->brandModel->where('good_brand_id', $brandData['good_brand_id'])->update($brandData);
    }


}
