<?php

namespace App\Http\Controllers\Users;
use App\Http\Controllers\Controller;
use App\Services\ShopActionService;
use Request;


class ShopActionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $shopActionService;
    public function __construct(ShopActionService $shopActionService)
    {
        $this->shopActionService = $shopActionService;
    }
    // 充值
    public function recharge()
    {
        $param = [
            "uid"           => Request::input("uid"),
            "shop_id"       => Request::input("shop_id"),
            "charge_money"  => Request::input("charge_money"),
            "give_money"    => Request::input("give_money"),
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
            "give_money"     => "required|numeric",
            "pay_cash"       => "required|numeric",
            "pay_card"       => "required|numeric",
            "pay_mobile"     => "required|numeric",
            "pay_emps"       => "required|array",
            "add_time"       => "required|string",
        ];

        $this->validation($param, $rule);
        $param['cashier_id'] = $this->getCashierId();
        return $this->shopActionService->recharge($param);
    }

    //充值产品卡
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
            "pay_cash"       => "required|numeric",
            "pay_card"       => "required|numeric",
            "pay_mobile"     => "required|numeric",
            "pay_emps"       => "required|array",
            "add_time"       => "required|string",
        ];

        $this->validation($param, $rule);
        $param['cashier_id'] = $this->getCashierId();
        return $this->shopActionService->chargeGoods($param);
    }

    //购买项目
    public function buyItems()
    {
        $param = [
            "uid"           => Request::input("uid"),   //用户UID
            "shop_id"       => Request::input('shop_id'),
            "selected_items"=> Request::input("selectedItems"), //购买项目明细
            "items_money"   => Request::input("itemsMoney"), //项目总金额
            "pay_balance"   => Request::input("pay_balance", 0), //卡扣余额
            "pay_give_balance"   => Request::input("pay_give_balance", 0), //卡扣产品余额
            "pay_cash"      => Request::input("pay_cash", 0), //支付现金
            "pay_card"      => Request::input("pay_card", 0), //银行卡
            "pay_mobile"    => Request::input("pay_mobile", 0), //移动支付
            "pay_emps"      => Request::input("pay_emps", []), //员工金额分配
            "add_time"      => Request::input("add_time"), //添加时间
            "server_emps"   => Request::input("server_emps"), //散客传该参数
        ];
        $rule = [
            "uid"            => "required|integer",
            "shop_id"        => "required|integer",
            "selected_items" => "required|array",
            "items_money"    => "numeric|required",
            "pay_balance"    => "required|numeric",
            "pay_card"       => "required|numeric",
            "pay_cash"       => "required|numeric",
            "pay_mobile"     => "required|numeric",
            "pay_emps"       => "required|array",
            "add_time"       => "required|string",
            "server_emps"    => "nullable|Array",
        ];

        $this->validation($param, $rule);
        $param['cashier_id'] = $this->getCashierId();
        return $this->shopActionService->buyItems($param);
    }

    //耗卡
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

        return $this->shopActionService->useItems($param);
    }

    //还款
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
        return $this->shopActionService->repay($param);
    }

    //购买产品
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
            "goods_money"    => "required|numeric",
            "pay_balance"    => "required|numeric",
            "use_good_money" => "required|numeric",
            "pay_card"       => "required|numeric",
            "pay_cash"       => "required|numeric",
            "pay_mobile"     => "required|numeric",
            "pay_emps"       => "required|array",
            "add_time"       => "required|string",
        ];
        $this->validation($param, $rule);
        $param['cashier_id'] = $this->getCashierId();

        return $this->shopActionService->buyGoods($param);
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
            "pay_balance"   => Request::input("pay_balance", 0),//使用会员卡金额
            "good_money"    => Request::input("good_money", 0),//使用产品卡扣
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

            "change_fee"     => "required|numeric",
            "pay_balance"    => "required|numeric",
            "good_money"     => "required|numeric",
            "pay_card"       => "required|numeric",
            "pay_cash"       => "required|numeric",
            "pay_mobile"     => "required|numeric",

            "pay_emps"       => "required|array",
            "add_time"       => "required|string",
        ];
        $this->validation($param, $rule);
        $param['cashier_id'] = $this->getCashierId();

        return $this->shopActionService->changeItems($param);
    }

    public function orderTime()
    {
        $param = [
            "uid"         => Request::input('uid'),
            "emp_id"      => Request::input('emp_id'),
            "emp_name"    => Request::input('emp_name'),
            "shop_id"     => Request::input('shop_id'),
            'remark'      => Request::input('remark',""),
            'order_time'  => Request::input('order_time')
        ];
        $rule = [
            "uid"       => "required",
            "emp_id"    => "required",
            "emp_name"  => "required",
            "shop_id"   => "required",
            'order_time'=> "required"
        ];

        $this->validation($param, $rule);

        $data = $this->shopActionService->orderTime($param);
        return $data;
    }

    public function reportOrderData()
    {
        $param = [
            "report_msg"  => Request::input('report_msg'),
        ];
        $rule = [
            "report_msg"  => "required",
        ];
        $this->validation($param, $rule);
        $param['cashier_id'] = $this->getCashierId();

        $data = $this->shopActionService->reportOrderData($param);
        return $data;
    }

}
