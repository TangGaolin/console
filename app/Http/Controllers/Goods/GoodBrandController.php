<?php

namespace App\Http\Controllers\Goods;
use App\Http\Controllers\Controller;
use App\Services\GoodService;
use Request;

class GoodBrandController extends Controller
{
    protected $goodService;

    public function __construct(GoodService $goodService)
    {
        $this->goodService = $goodService;
    }


    public function addGoodBrand()
    {
        $param = [
            "good_brand_name" => Request::input('good_brand_name'),
        ];
        $rule = [
            "good_brand_name" => "required|string",
        ];
        $msg = [
            'good_brand_name.required' => "要求输入品牌名称！"
        ];

        $this->validation($param, $rule, $msg);

        $param['admin_id'] = $this->getAid();

        return $this->goodService->addGoodBrand($param);
    }

    public function getBrandList()
    {
        $param = [
            'good_brand_name' => Request::input('good_brand_name'),
            'status'          => Request::input('status')
        ];
        $rule = [
            "good_brand_name" => "nullable|integer",
            "status"    => "nullable|integer"
        ];
        $this->validation($param, $rule);
        $data = $this->goodService->getBrandList($param);
        return $data;
    }

    public function updateGood()
    {
        $param = [
            "good_id"       => Request::input('good_id'),
            "good_name"     => Request::input('good_name'),
            "brand"         => Request::input('brand'),
            "speci"         => Request::input('speci'),
            "unit"          => Request::input('unit'),
            "cost"          => Request::input('cost'),
            "price"         => Request::input('price'),
            "good_details"  => Request::input('good_details'),
            "descri"        => Request::input('descri')
        ];
        $rule = [
            "good_id"       => "required|integer",
            "good_name"     => "required|string",
            "brand"         => "required|string",
            "speci"         => "string",
            "unit"          => "string",
            "cost"          => "numeric",
            "price"         => "numeric",
            "good_details"  => "string",
            "descri"        => "string"
        ];
        $this->validation($param, $rule);
        return $this->goodService->updateGood($param);
    }

}
