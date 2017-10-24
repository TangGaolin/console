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

    public function getOrderList()
    {
        $param = [
            "uid"           => Request::input("uid"),
            "shop_id"       => Request::input("shop_id"),
            "order_id"      => Request::input("order_id"),
            "select_date"   => Request::input("select_date"),
            "date_range"    => Request::input("date_range"),
            "cur_page"      => Request::input("cur_page", 1),
            "limit"         => Request::input("limit", 10),
            "status"        => Request::input("status")
        ];
        $rule = [
            "uid"           => "nullable|integer",
            "shop_id"       => "nullable|integer",
            "order_id"      => "nullable|integer",
            "select_date"   => "nullable|date",
            "cur_page"      => "required|integer",
            "limit"         => "required|integer",
            "status"        => "nullable|integer"
        ];

        $this->validation($param, $rule);

        return $this->usersAccountService->getOrderList($param);
    }

    public function getItemList()
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

        return $this->usersAccountService->getItemList($param);
    }

    public function getUseOrderList()
    {
        $param = [
            "uid"           => Request::input("uid"),
            "order_id"      => Request::input("order_id"),
            "shop_id"       => Request::input("shop_id"),
            "select_date"   => Request::input("select_date"),
            "date_range"    => Request::input("date_range"),
            "cur_page"      => Request::input("cur_page", 1),
            "limit"         => Request::input("limit", 10)
        ];
        $rule = [
            "uid"           => "nullable|integer",
            "shop_id"       => "nullable|integer",
            "cur_page"      => "required|integer",
            "select_date"   => "nullable|date",
            "limit"         => "required|integer",
        ];

        $this->validation($param, $rule);

        return $this->usersAccountService->getUseOrderList($param);
    }

}
