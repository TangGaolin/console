<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemType extends Model
{
    //
    protected $table = 'item_type';

    public $timestamps = false;

    /**
     * 不允许被赋值的属性
     * @var array
     */
    protected $guarded = [];
}
