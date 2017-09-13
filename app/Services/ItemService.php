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
        $this->itemRepository->addItemType($itemTypeData);
        return success();
    }

    public function getItemType()
    {
        $data = $this->itemRepository->getItemTypeList();
        return success($data);
    }

    public function modifyItemType($param)
    {
        $itemTypeData = $param;
        $res = $this->itemRepository->modifyItemType($itemTypeData);
        if(!$res){
            return fail(601, "项目类别名称已经存在");
        }
        return success();
    }

    public function addItem($param)
    {
        $itemData = $param;
        $res = $this->itemRepository->addItem($itemData);
        if(!$res){
            return fail(601, "项目名称已经存在");
        }
        return success();
    }

    public function getItemList($param)
    {
        if(0 == $param['item_type']){
            unset($param['item_type']);
        }
        if(checkParam($param,'item_name')) {
            if (!preg_match("/[\x7f-\xff]/", $param['item_name'])) {  //判断字符串中是否有中文
                $param['pinyin'] = $param['item_name'];
                unset($param['item_name']);
            }
        }
        $data = $this->itemRepository->getItemList($param);
        return success($data);
    }

    public function modifyItem($param)
    {
        $itemData = $param;
        $res =  $this->itemRepository->updateItem($itemData);
        if(!$res){
            return fail(601, "项目名称已经存在");
        }
        return success();
    }

}