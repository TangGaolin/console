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

    public function updateBrand()
    {
        $param = [
            "good_brand_id"       => Request::input('good_brand_id'),
            "good_brand_name"     => Request::input('good_brand_name')
        ];
        $rule = [
            "good_brand_id"       => "required|integer",
            "good_brand_name"     => "required|string"
        ];
        $this->validation($param, $rule);
        $param['admin_id'] = $this->getAid();
        return $this->goodService->updateBrand($param);
    }

}
