<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RbacRoleUser extends Model
{
    protected $table = 'rbac_role_user';

    public $timestamps = false;

    /**
     * 不允许被赋值的属性
     * @var array
     */
    protected $guarded = [];
}
