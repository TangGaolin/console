<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    //
    protected $table = 'shop';

    public $timestamps = false;

    /**
     * 不允许被赋值的属性
     * @var array
     */
    protected $guarded = [];

    protected $casts = [
        'city'          => 'array'
    ];

    public function getCityAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }
}
