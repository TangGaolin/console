<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RbacRoleModels extends Model
{
    protected $table = 'rbac_role';

    public $timestamps = false;

    /**
     * 不允许被赋值的属性
     * @var array
     */
    protected $guarded = [];
}
