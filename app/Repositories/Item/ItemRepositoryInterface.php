<?php
namespace App\Repositories\Item;

interface ItemRepositoryInterface
{
    public function addItemType($itemTypeData);
    public function getItemTypeList();
    public function updateTypeName($itemTypeData);


    public function addItem($itemData);
    public function getItemList($whereParam);
    public function updateItem($itemData);
    public function disableItem($itemData);
}
