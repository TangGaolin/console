<?php
namespace App\Repositories\Item;

interface ItemRepositoryInterface
{
    public function addItem($itemData);
    public function getItemList();
    public function updateItem($itemData);
    public function disableItem($itemData);
}
