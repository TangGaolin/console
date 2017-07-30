<?php
namespace App\Repositories\Goods;

use App\Models\Goods;
use DB;

class GoodsRepository implements GoodsRepositoryInterface
{

    protected $goods;

    public function __construct(Goods $goods)
    {
        $this->goods = $goods;
    }

    public function getGoodsList($whereParam)
    {
        $select = $this->goods->select();
        !empty($whereParam['good_name']) && $select = $select->where("good_name", "like", $whereParam["good_name"].'%');
        $countSelect = $select;
        $count       = $countSelect->count();
        $res         = $select->skip(($whereParam['cur_page']-1) * $whereParam['limit'])->take($whereParam['limit'])->get();
        return [
            'totalSize' => $count,
            'data'      => $res,
        ];
    }

    public function addGood($goodData)
    {
        return $this->goods->insert($goodData);
    }

    public function updateGood($goodData)
    {
        return $this->goods->where('good_id', '=', $goodData['good_id'])->update($goodData);
    }


}
