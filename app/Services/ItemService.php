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

    protected $responseCode;
    protected $itemRepository;

    public function __construct(ItemRepositoryInterface $itemRepository)
    {
        $this->responseCode = config('response_code');
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

    public function addItem($param)
    {
        $itemData = $param;
        return $this->itemRepository->addItem($itemData);
    }

    public function getItemList($param)
    {
        if(0 == $param['item_type']){
            unset($param['item_type']);
        }
        return $this->itemRepository->getItemList($param);
    }
}