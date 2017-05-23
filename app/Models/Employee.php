<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    //
    protected $table = 'employee';

    public $timestamps = false;

    /**
     * 不允许被赋值的属性
     * @var array
     */
    protected $guarded = [];
}
