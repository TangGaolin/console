<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserOrderTime extends Model
{
    //
    protected $table = 'user_order_time';

    public $timestamps = false;

    /**
     * 不允许被赋值的属性
     * @var array
     */
    protected $guarded = [];
}
