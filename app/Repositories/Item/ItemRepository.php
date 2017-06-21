<?php
namespace App\Repositories\Item;

use App\Models\Item;
use DB;

class ItemRepository implements ItemRepositoryInterface
{

    protected $item;
    public function __construct(Item $item)
    {
        $this->item = $item;
    }

    public function addItem($itemData)
    {
        return $this->item->insert($itemData);
    }

    public function getItemList()
    {
        $result =  $this->item->select('item_id','item_name','item_type','price','times','emp_free','status')->get();
        return $result->toArray();
    }

    public function updateItem($itemData)
    {
        return $this->item->where(['item_id' => $itemData['item']])->update($itemData);
    }

    public function disableItem($itemData)
    {
        return $this->item->where(['item_id' => $itemData['item']])->update(['status' => -1]);
    }


}
