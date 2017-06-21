<?php
namespace App\Repositories\Item;

use App\Models\ItemType;
use DB;

class ItemTypeRepository implements ItemTypeRepositoryInterface
{

    protected $itemType;

    public function __construct(ItemType $itemType)
    {
        $this->itemType = $itemType;
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
