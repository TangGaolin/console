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




}
