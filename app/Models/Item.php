<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    //
    protected $table = 'items';

    public $timestamps = false;

    /**
     * 不允许被赋值的属性
     * @var array
     */
    protected $guarded = [];
}
