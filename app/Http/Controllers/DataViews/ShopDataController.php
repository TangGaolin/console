<?php

namespace App\Http\Controllers\DataViews;
use App\Http\Controllers\Controller;
use App\Services\DataViewsService;
use Request;


class ShopDataController extends Controller
{


    /**
     * Create a new controller instance.
     *
     * @return void
     */

    protected $dataViewsService;
    public function __construct(DataViewsService $dataViewsService)
    {
        $this->dataViewsService = $dataViewsService;
    }

    //门店当月
    public function getShopDataView()
    {
        $param = [
            "shop_id" => Request::input('shop_id'),
            "year"    => Request::input('year'),
            "mouth"   => Request::input('mouth'),
        ];

        $rule = [
            'shop_id' => "required|integer",
            'year'    => "nullable|integer",
            'mouth'   => "nullable|integer",
        ];
        $this->validation($param, $rule);

        return $this->dataViewsService->getShopDataView($param);
    }

    public function getShopsDataView()
    {
        $param = [
            "shop_ids"=> Request::input('shop_ids'),
            "year"    => Request::input('year'),
            "mouth"   => Request::input('mouth'),
        ];

        $rule = [
            'shop_ids' => "required|Array",
            'year'     => "nullable|integer",
            'mouth'    => "nullable|integer",
        ];

        $this->validation($param, $rule);

        return $this->dataViewsService->getShopsDataView($param);
    }





}
