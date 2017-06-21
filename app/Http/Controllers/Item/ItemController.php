<?php

namespace App\Http\Controllers\Item;
use App\Http\Controllers\Controller;
use App\Services\ItemService;
use Request;

class ItemController extends Controller
{
    protected $itemService;

    public function __construct(ItemService $itemService)
    {
        $this->itemService = $itemService;
    }

    public function addItemType()
    {
        $param = [
            "item_type_name" => Request::input('item_type_name')
        ];
        $rule = [
            "item_type_name" => "required|string",
        ];
        $this->validation($param, $rule);

        $this->itemService->addItemType($param);
        return $this->success();
    }

    public function getItemType()
    {
        $data = $this->itemService->getItemType();
        return $this->success($data);
    }


    public function addItem()
    {
        $param = [
            "item_name" => Request::input('item_name'),
            "item_type" => Request::input('item_type'),
            "price"     => Request::input('price'),
            "times"     => Request::input('times'),
            "emp_fee"   => Request::input('emp_fee'),
        ];
        $rule = [
            "item_name" => "required|string",
            "item_type" => "required|integer",
            "price"     => "required|numeric",
            "times"     => "required|integer",
            "emp_fee"   => "required|numeric",
        ];
        $this->validation($param, $rule);

        $this->itemService->addItem($param);
        return $this->success();
    }


}
