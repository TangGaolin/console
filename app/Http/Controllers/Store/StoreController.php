<?php

namespace App\Http\Controllers\Store;
use App\Http\Controllers\Controller;
use Request;

use App\Services\StoreService;
class StoreController extends Controller
{

    protected $request;
    protected $storeService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(StoreService $storeService)
    {
        $this->storeService = $storeService;
    }

    public function getStoreList(){

        $result =  $this->storeService->getStoreList();

        return $this->success($result);
    }

    public function updateStoreInfo()
    {
        $param = Request::all();
        $rule = [
            'shop_id'       => 'required|Integer',
            'shop_name'     => 'string',
            'shop_tel'      => 'string',
            'address'       => 'string',
            'city'          => 'Array'
        ];

        $this->validation($param, $rule);
        $result =  $this->storeService->updateStoreInfo($param);
        return $this->success();
    }

    public function addStore()
    {
        $param = Request::all();
        $rule = [
            'shop_name'     => 'required|string',
            'shop_tel'      => 'string',
            'address'       => 'string',
            'city'          => 'Array'
        ];

        $this->validation($param, $rule);
        $result =  $this->storeService->addStore($param);
        return $this->success();
    }


}
