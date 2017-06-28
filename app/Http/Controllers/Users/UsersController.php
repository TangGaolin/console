<?php

namespace App\Http\Controllers\Users;
use App\Http\Controllers\Controller;
use App\Services\UsersService;
use Request;


class UsersController extends Controller
{

    protected $storeService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    protected $usersService;
    public function __construct(UsersService $usersService)
    {
        $this->usersService = $usersService;
    }


    public function addUser()
    {
        $param = [
            "phone_no"  => Request::input("phone_no"),
            "user_name" => Request::input("user_name",""),
            "shop_id"   => Request::input("shop_id"),
            "emp_id"    => Request::input("emp_id"),
            "birthday"  => Request::input("birthday"),
            "source"    => Request::input("source",""),
            "remark"    => Request::input("remark",""),
            "add_time"  => Request::input("add_time","")
        ];
        $rule = [
            "phone_no"   => "required|string",
            "user_name"  => "nullable|string",
            "shop_id"    => "integer",
            "emp_id"     => "integer",
            "birthday"   => "nullable|date",
            "source"     => "nullable|string",
            "remark"     => "string",
            "add_time"   => "string",
        ];

        $this->validation($param, $rule);
        return $this->usersService->addUser($param);
    }

}
