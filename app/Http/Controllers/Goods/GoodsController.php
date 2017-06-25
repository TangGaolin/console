<?php

namespace App\Http\Controllers\Goods;
use App\Http\Controllers\Controller;
use App\Services\GoodService;
use Request;

class GoodsController extends Controller
{
    protected $goodService;

    public function __construct(GoodService $goodService)
    {
        $this->goodService = $goodService;
    }


    public function addGood()
    {
        $param = [
            "good_name" => Request::input('good_name'),
            "brand" => Request::input('brand'),
            "speci" => Request::input('speci'),
            "unit" => Request::input('unit'),
            "cost" => Request::input('cost'),
            "price" => Request::input('price'),
            //"good_details" => Request::input('good_details'),
            "descri" => Request::input('descri')
        ];
        $rule = [
            "good_name" => "required|string",
            "brand" => "required|string",
            "speci" => "string",
            "unit" => "string",
            "cost" => "numeric",
            "price" => "numeric",
            "descri" => "string"
        ];
        $this->validation($param, $rule);

        return $this->goodService->addGood($param);
    }

    public function getGoodsList()
    {
        $param = [
            'cur_page'       => Request::input('cur_page', 1),
            'limit'          => Request::input('limit', 15)
        ];
        $rule = [
            "cur_page" => "integer",
            "limit"    => "integer"
        ];
        $this->validation($param, $rule);
        $data = $this->goodService->getGoodsList($param);
        return $this->success($data);
    }

    public function updateGood()
    {
        $param = [
            "good_id" => Request::input('good_id'),
            "good_name" => Request::input('good_name'),
            "brand" => Request::input('brand'),
            "speci" => Request::input('speci'),
            "unit" => Request::input('unit'),
            "cost" => Request::input('cost'),
            "price" => Request::input('price'),
            //"good_details" => Request::input('good_details'),
            "descri" => Request::input('descri')
        ];
        $rule = [
            "good_id" => "required|integer",
            "good_name" => "required|string",
            "brand" => "required|string",
            "speci" => "string",
            "unit" => "string",
            "cost" => "numeric",
            "price" => "numeric",
            "descri" => "string"
        ];
        $this->validation($param, $rule);
        return $this->goodService->updateGood($param);
    }

}