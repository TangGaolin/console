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
        $param['cashier_id'] = $this->getCashierId();
        return $this->usersAccountService->recharge($param);
    }

    public function buyItems()
    {
        $param = [
            "uid"           => Request::input("uid"),   //用户UID
            "selected_items"=> Request::input("selectedItems"), //购买项目明细
            "items_money"   => Request::input("itemsMoney"), //项目总金额
            "pay_balance"   => Request::input("pay_balance", 0), //卡扣余额
            "pay_cash"      => Request::input("pay_cash", 0), //支付现金
            "pay_card"      => Request::input("pay_card", 0), //银行卡
            "pay_mobile"    => Request::input("pay_mobile", 0), //移动支付
            "pay_emps"      => Request::input("pay_emps", []), //员工金额分配
            "add_time"      => Request::input("add_time"), //添加时间
        ];

        $rule = [
            "uid"            => "required|integer",
            "selected_items" => "required|array",
            "items_money"    => "numeric",
            "pay_balance"    => "numeric",
            "pay_card"       => "numeric",
            "pay_cash"       => "numeric",
            "pay_mobile"     => "numeric",
            "pay_emps"       => "required|array",
            "add_time"       => "required|string",
        ];

        $this->validation($param, $rule);
        $param['cashier_id'] = $this->getCashierId();
        return $this->usersAccountService->buyItems($param);
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



}
