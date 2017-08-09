<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoodBrand extends Model
{
    //
    protected $table = 'good_brand';

    public $timestamps = false;

    /**
     * 不允许被赋值的属性
     * @var array
     */
    protected $guarded = [];
}
