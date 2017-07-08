<?php

namespace App\Http\Controllers\Users;
use App\Http\Controllers\Controller;
use App\Services\UsersAccountService;
use Request;


class UsersAccountController extends Controller
{


    /**
     * Create a new controller instance.
     *
     * @return void
     */

    protected $usersAccountService;
    public function __construct(UsersAccountService $usersAccountService)
    {
        $this->usersAccountService = $usersAccountService;
    }


    public function recharge()
    {
        $param = [
            "uid"           => Request::input("uid"),
            "charge_money"  => Request::input("charge_money"),
            "pay_cash"      => Request::input("pay_cash",0),
            "pay_card"      => Request::input("pay_card",0),
            "pay_mobile"    => Request::input("pay_mobile",0),
            "pay_emps"      => Request::input("pay_emps", []),
            "add_time"      => Request::input("add_time"),
        ];
        $rule = [
            "uid"            => "required|integer",
            "charge_money"   => "required|numeric",
            "pay_cash"       => "numeric",
            "pay_card"       => "numeric",
            "pay_mobile"     => "numeric",
            "pay_emps"       => "required|array",
            "add_time"       => "required|string",
        ];

        $this->validation($param, $rule);

        return $this->usersAccountService->recharge($param);
    }

    public function getOrderList()
    {
        $param = [
            "uid"           => Request::input("uid"),
            "shop_id"       => Request::input("shop_id"),
            "cur_page"      => Request::input("cur_page",1),
            "limit"         => Request::input("limit",10)
        ];
        $rule = [
            "uid"           => "nullable|integer",
            "cur_page"      => "required|integer",
            "limit"         => "required|integer",
        ];

        $this->validation($param, $rule);

        return $this->usersAccountService->getOrderList($param);
    }



}
