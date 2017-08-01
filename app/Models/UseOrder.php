<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UseOrder extends Model
{
    //
    protected $table = 'use_order';

    protected $primaryKey = 'use_order_id';
    public $timestamps = false;
    public $incrementing = false;

    /**
     * 不允许被赋值的属性
     * @var array
     */
    protected $guarded = [];

    public function getItemsInfoAttribute($value)
    {
        return json_decode($value, true) ?: $value;
    }
}
