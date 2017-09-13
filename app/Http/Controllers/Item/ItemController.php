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

    /*
     * 添加项目类别
     * */
    public function addItemType()
    {
        $param = [
            "item_type_name" => Request::input('item_type_name')
        ];
        $rule = [
            "item_type_name" => "required|string",
        ];
        $this->validation($param, $rule);

        return $this->itemService->addItemType($param);
    }

    /*
     * 获取项目类别列表
     * */
    public function getItemType()
    {
        $data = $this->itemService->getItemType();
        return $data;
    }

    /*
     * 修改项目类型
     * */
    public function modifyItemType()
    {
        $param = [
            "item_type_id"   => Request::input('item_type_id'),
            "item_type_name" => Request::input('item_type_name'),
        ];
        $rule = [
            "item_type_id"   => "required|integer",
            "item_type_name" => "required|string",
        ];
        $this->validation($param, $rule);
        return $this->itemService->modifyItemType($param);
    }

    /*
     * 新增项目
     * */
    public function addItem()
    {
        $param = [
            "item_name" => Request::input('item_name'),
            "pinyin"    => Request::input('pinyin'),
            "item_type" => Request::input('item_type'),
            "price"     => Request::input('price'),
            "times"     => Request::input('times'),
            "emp_fee"   => Request::input('emp_fee'),
        ];
        $rule = [
            "item_name" => "required|string",
            "pinyin" => "nullable|string",
            "item_type" => "required|integer",
            "price"     => "required|numeric",
            "times"     => "required|integer",
            "emp_fee"   => "required|numeric",
        ];
        $this->validation($param, $rule);

        return $this->itemService->addItem($param);
    }

    /*
     * 获取项目列表
     * */
    public function getItemList()
    {
        $param = [
            'item_type'      => Request::input('item_type',0),
            'item_name'      => Request::input('item_name'),
            'cur_page'       => Request::input('cur_page', 1),
            'limit'          => Request::input('limit', 15)
        ];
        $rule = [
            "item_type" => "integer",
            "item_name" => "string",
            "cur_page"  => "integer",
            "limit"     => "integer"
        ];
        $this->validation($param, $rule);
        $data = $this->itemService->getItemList($param);

        return $data;
    }

    /*
     * 修改项目
     * */
    public function modifyItem()
    {
        $param = [
            "item_id"   => Request::input('item_id'),
            "item_name" => Request::input('item_name'),
            "pinyin" => Request::input('pinyin'),
            "item_type" => Request::input('item_type'),
            "price"     => Request::input('price'),
            "times"     => Request::input('times'),
            "emp_fee"   => Request::input('emp_fee'),
        ];
        $rule = [
            "item_id"   => "required|integer",
            "item_name" => "required|string",
            "pinyin"    => "nullable|string",
            "item_type" => "required|integer",
            "price"     => "required|numeric",
            "times"     => "required|integer",
            "emp_fee"   => "required|numeric",
        ];
        $this->validation($param, $rule);

        return $this->itemService->modifyItem($param);
    }


}
