<?php
/**
 * Created by PhpStorm.
 * User: gaolintang
 * Date: 2017/5/23
 * Time: 下午3:27
 */
namespace App\Services;

use App\Repositories\Item\ItemRepositoryInterface;
use Excel;


Class ItemService
{

    protected $itemRepository;

    public function __construct(ItemRepositoryInterface $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    public function addItemType($param)
    {
        $itemTypeData = $param;
        return $this->itemRepository->addItemType($itemTypeData);
    }

    public function getItemType()
    {
        return $this->itemRepository->getItemTypeList();
    }

    public function modifyItemType($param)
    {
        $itemTypeData = $param;
        $res = $this->itemRepository->modifyItemType($itemTypeData);
        if(!$res){
            return [
                'statusCode' => config('response_code.STATUSCODE_ITEMERROR'),
                'msg'        => "项目类别名称已经存在",
                'success'    => false
            ];
        }
        return $this->success();
    }

    public function addItem($param)
    {
        $itemData = $param;
        $res = $this->itemRepository->addItem($itemData);
        if(!$res){
            return [
                'statusCode' => config('response_code.STATUSCODE_ITEMERROR'),
                'msg'        => "项目名称已经存在",
                'success'    => false
            ];
        }
        return $this->success();
    }

    public function getItemList($param)
    {
        if(0 == $param['item_type']){
            unset($param['item_type']);
        }
        return $this->itemRepository->getItemList($param);
    }

    public function modifyItem($param)
    {
        $itemData = $param;
        $res =  $this->itemRepository->updateItem($itemData);
        if(!$res){
            return [
                'statusCode' => config('response_code.STATUSCODE_ITEMERROR'),
                'msg'        => "项目名称已经存在",
                'success'    => false
            ];
        }
        return $this->success();
    }

    public function success()
    {
        return [
            'statusCode' => config('response_code.STATUSCODE_SUCCESS'),
            'msg'        => config('response_code.MSG_OK'),
            'success'    => true
        ];
    }
}