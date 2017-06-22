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
        $res =  $res = $this->item->where(["item_name" => $itemData["item_name"]])->first();
        if($res) {
            return false;
        }
        return $this->item->insert($itemData);
    }


    public function getItemList($whereParam)
    {
        $select =  $this->item->select('item_id','item_name','item_type','price','times','emp_fee','status');

        !empty($whereParam['item_type']) && $select = $select->where("item_type", "=", $whereParam["item_type"]);
        !empty($whereParam['item_name']) && $select = $select->where("item_name", "like", $whereParam["item_name"].'%');

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
        $res =  $res = $this->item->where(["item_name" => $itemData["item_name"]])->first();
        if($res && ($itemData['item_id'] != $res["item_id"])) {
            return false;
        }
        $this->item->where(['item_id' => $itemData['item_id']])->update($itemData);
        return true;
    }

    public function disableItem($itemData)
    {
        return $this->item->where(['item_id' => $itemData['item']])->update(['status' => -1]);
    }

    /*********** item type   *********/

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

    public function modifyItemType($itemTypeData)
    {

        $res =  $res = $this->itemType->where(["item_type_name" => $itemTypeData["item_type_name"]])->first();
        if($res && ($itemTypeData['item_type_id'] != $res["item_type_id"])) {
            return false;
        }
        $this->itemType->where(['item_type_id' => $itemTypeData['item_type_id']])->update($itemTypeData);
        return true;
    }


}
