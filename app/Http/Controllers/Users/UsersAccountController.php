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
            "shop_id"       => Request::input("shop_id"),
            "charge_money"  => Request::input("charge_money"),
            "pay_cash"      => Request::input("pay_cash", 0),
            "pay_card"      => Request::input("pay_card",0),
            "pay_mobile"    => Request::input("pay_mobile",0),
            "pay_emps"      => Request::input("pay_emps", []),
            "add_time"      => Request::input("add_time"),
        ];
        $rule = [
            "uid"            => "required|integer",
            "shop_id"        => "required|integer",
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


    public function chargeGoods()
    {
        $param = [
            "uid"           => Request::input("uid"),
            "shop_id"       => Request::input("shop_id"),
            "good_money"    => Request::input("good_money"),  //产品价值
            "charge_money"  => Request::input("charge_money"), //充值金额
            "pay_cash"      => Request::input("pay_cash",0),
            "pay_card"      => Request::input("pay_card",0),
            "pay_mobile"    => Request::input("pay_mobile",0),
            "pay_emps"      => Request::input("pay_emps", []),
            "add_time"      => Request::input("add_time"),
        ];
        $rule = [
            "uid"            => "required|integer",
            "shop_id"        => "required|integer",
            "good_money"     => "required|numeric",
            "charge_money"   => "required|numeric",
            "pay_cash"       => "numeric",
            "pay_card"       => "numeric",
            "pay_mobile"     => "numeric",
            "pay_emps"       => "required|array",
            "add_time"       => "required|string",
        ];

        $this->validation($param, $rule);
        $param['cashier_id'] = $this->getCashierId();
        return $this->usersAccountService->chargeGoods($param);
    }

    public function buyItems()
    {
        $param = [
            "uid"           => Request::input("uid"),   //用户UID
            "shop_id"       => Request::input('shop_id'),
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
            "shop_id"        => "required|integer",
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
            "select_date"   => Request::input("select_date"),
            "cur_page"      => Request::input("cur_page", 1),
            "limit"         => Request::input("limit", 10),
            "status"        => Request::input("status")
        ];
        $rule = [
            "uid"           => "nullable|integer",
            "shop_id"       => "nullable|integer",
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

    public function useItems()
    {
        $param = [
            "uid"          => Request::input('uid'),
            "shop_id"      => Request::input('shop_id'),
            "select_items" => Request::input('select_items'),
            "add_time"     => Request::input('add_time')
        ];
        $rule = [
            "uid"          => "required|integer",
            "shop_id"      => "required|integer",
            "select_items" => "required|array",
            "add_time"     => "required|string"
        ];

        $this->validation($param, $rule);
        $param['cashier_id'] = $this->getCashierId();

        return $this->usersAccountService->useItems($param);
    }

    public function getUseOrderList()
    {
        $param = [
            "uid"           => Request::input("uid"),
            "shop_id"       => Request::input("shop_id"),
            "select_date"   => Request::input("select_date"),
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

    public function repay()
    {
        $param = [
            "uid"           => Request::input("uid"),
            "shop_id"       => Request::input("shop_id"),
            "order_id"      => Request::input("order_id"),
            "repay_money"   => Request::input("repay_money"),
            "pay_cash"      => Request::input("pay_cash"),
            "pay_card"      => Request::input("pay_card"),
            "pay_mobile"    => Request::input("pay_mobile"),
            "pay_emps"      => Request::input("pay_emps"),
            "add_time"      => Request::input("add_time"),
        ];
        $rule = [
            "uid"           => "required|integer",
            "shop_id"       => "required|integer",
            "order_id"      => "required|integer",
            "repay_money"   => "required|numeric",
            "pay_cash"      => "required|numeric",
            "pay_card"      => "required|numeric",
            "pay_mobile"    => "required|numeric",
            "pay_emps"      => "required|Array",
            "add_time"      => "required|string",
        ];

        $this->validation($param, $rule);
        $param['cashier_id'] = $this->getCashierId();
        return $this->usersAccountService->repay($param);
    }

    public function buyGoods()
    {
        $param = [
            "uid"           => Request::input("uid"),   //用户UID
            "shop_id"       => Request::input('shop_id'),
            "selected_goods"=> Request::input("selectedGoods"), //购买项目明细
            "goods_money"   => Request::input("goodsMoney"),  //产品总金额
            "pay_balance"   => Request::input("pay_balance", 0), //卡扣余额
            "use_good_money"=> Request::input("use_good_money", 0), //卡扣余额
            "pay_cash"      => Request::input("pay_cash", 0), //支付现金
            "pay_card"      => Request::input("pay_card", 0), //银行卡
            "pay_mobile"    => Request::input("pay_mobile", 0), //移动支付
            "pay_emps"      => Request::input("pay_emps", []), //员工金额分配
            "add_time"      => Request::input("add_time"), //添加时间
        ];

        $rule = [
            "uid"            => "required|integer",
            "shop_id"        => "required|integer",
            "selected_goods" => "required|array",
            "goods_money"    => "numeric",
            "pay_balance"    => "numeric",
            "use_good_money" => "numeric",
            "pay_card"       => "numeric",
            "pay_cash"       => "numeric",
            "pay_mobile"     => "numeric",
            "pay_emps"       => "required|array",
            "add_time"       => "required|string",
        ];
        $this->validation($param, $rule);
        $param['cashier_id'] = $this->getCashierId();

        return $this->usersAccountService->buyGoods($param);
    }

    //退换项目功能
    public function changeItems()
    {
        $param = [
            "uid"           => Request::input("uid"),   //用户UID
            "shop_id"       => Request::input('shop_id'), // 门店id

            "select_items"  => Request::input("select_items"), //选择要退的项目
            "item_money"    => Request::input("itemsMoney"),  //项目金额
            "select_new_items" => Request::input("selectedNewItems"), //选择新项目
            "new_item_money"=> Request::input("newItemMoney", 0), //新项目金额

            "change_fee"    => Request::input("change_fee", 0), //本单手续费
            "use_balance"   => Request::input("use_balance", 0),//使用会员卡金额
            "pay_cash"      => Request::input("pay_cash", 0),   //支付现金
            "pay_card"      => Request::input("pay_card", 0),   //银行卡
            "pay_mobile"    => Request::input("pay_mobile", 0), //移动支付

            "pay_emps"      => Request::input("pay_emps", []), //员工金额分配
            "add_time"      => Request::input("add_time"), //添加时间
        ];

        $rule = [
            "uid"            => "required|integer",
            "shop_id"        => "required|integer",

            "select_items"  => "required|array",
            "item_money"    => "numeric",
            "select_new_items" => "array",
            "new_item_money" => "numeric",

            "change_fee"    => "numeric",
            "use_balance"    => "numeric",
            "pay_card"       => "numeric",
            "pay_cash"       => "numeric",
            "pay_mobile"     => "numeric",

            "pay_emps"       => "required|array",
            "add_time"       => "required|string",
        ];
        $this->validation($param, $rule);
        $param['cashier_id'] = $this->getCashierId();


        dd($param);

        return $this->usersAccountService->changeItems($param);
    }



}
