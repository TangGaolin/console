<?php
namespace App\Repositories\Item;

use App\Models\Item;
use App\Models\ItemType;
use DB;

class ItemRepository implements ItemRepositoryInterface
{

    protected $item;
    protected $itemType;

    public function __construct(Item $item, ItemType $itemType)
    {
        $this->item = $item;
        $this->itemType = $itemType;
    }

    public function addItem($itemData)
    {
        return $this->item->insert($itemData);
    }

    public function getItemList($whereParam)
    {
        $select =  $this->item->select('item_id','item_name','item_type','price','times','emp_fee','status');


        $countSelect = $select;
        $count       = $countSelect->count();
        $res         = $select->skip(($whereParam['cur_page']-1) * $whereParam['limit'])->take($whereParam['limit'])->get();
        return [
            'totalSize' => $count,
            'data'      => $res,
        ];
    }

    public function updateItem($itemData)
    {
        return $this->item->where(['item_id' => $itemData['item']])->update($itemData);
    }

    public function disableItem($itemData)
    {
        return $this->item->where(['item_id' => $itemData['item']])->update(['status' => -1]);
    }

    public function addItemType($itemTypeData)
    {
        return $this->itemType->insert($itemTypeData);
    }

    public function getItemTypeList()
    {
        $result = $this->itemType->select('item_type_id','item_type_name')->where('status','=', 1)
            ->get();
        return $result->toArray();
    }

    public function updateTypeName($itemTypeData)
    {
        return $this->itemType->where('item_type_id', $itemTypeData['item_type_id'])->update($itemTypeData);
    }


}
