<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $table = 'order';

    protected $primaryKey = 'order_id';
    public $timestamps = false;
    public $incrementing = false;

    /**
     * 不允许被赋值的属性
     * @var array
     */
    protected $guarded = [];

    public function getEmpInfoAttribute($value)
    {
        return json_decode($value, true) ?: $value;
    }
}
