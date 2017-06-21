<?php
namespace App\Repositories\Item;

interface ItemTypeRepositoryInterface
{
    public function addItemType($itemTypeData);
    public function getItemTypeList();
    public function updateTypeName($itemTypeData);

}
