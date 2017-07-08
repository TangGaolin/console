<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmpOrder extends Model
{
    //
    protected $table = 'emp_orders';

    public $timestamps = false;

    /**
     * 不允许被赋值的属性
     * @var array
     */
    protected $guarded = [];
}
