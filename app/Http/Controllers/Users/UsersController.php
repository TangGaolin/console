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

    //获取用户列表 or 查询用户
    public function getUserList()
    {
        $param = [
            "user_name_phone"  => Request::input("user_name_phone"),
            "shop_id"          => Request::input("shop_id"),
            "emp_id"           => Request::input("emp_id"),
            "cur_page"         => Request::input("cur_page", 1),
            "limit"            => Request::input("limit", 15),
        ];
        $rule = [
            "user_name_phone"   => "nullable|string",
            "shop_id"           => "nullable|integer",
            "emp_id"           => "nullable|integer",
            "cur_page"          => "integer",
            "limit"             => "integer",
        ];

        $this->validation($param, $rule);
        return $this->usersService->getUserList($param);
    }

    //添加用户
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

    public function importUser() {
        $param = [
            'file'      => Request::file('file'),
            'shop_id'   => Request::input('shop_id'),
        ];
        $rule = [
            'file'      =>  "required",
            'shop_id'   =>  "required|integer",
        ];
        $this->validation($param,$rule);

        return $this->usersService->importUser($param);
    }

    // 更新用户信息
    public function updateUser()
    {
        $param = [
            "uid"       => Request::input("uid"),
            "phone_no"  => Request::input("phone_no"),
            "user_name" => Request::input("user_name"),
            "shop_id"   => Request::input("shop_id"),
            "emp_id"    => Request::input("emp_id"),
            "birthday"  => Request::input("birthday"),
            "remark"    => Request::input("remark"),
            "source"    => Request::input("source"),

        ];
        $rule = [
            "uid"        => "required|integer",
            "phone_no"   => "nullable|numeric",
            "user_name"  => "nullable|string",
            "shop_id"    => "nullable|integer",
            "emp_id"     => "nullable|integer",
            "birthday"   => "nullable|date",
            "source"     => "nullable|string",
        ];
        $this->validation($param, $rule);
        return $this->usersService->updateUser($param);
    }

    // 获取用户详情
    public function getUserDetail()
    {
        $param = [
            "uid"       => Request::input("uid"),
            "phone_no"  => Request::input("phone_no"),
            "shop_id"   => Request::input("shop_id")
        ];
        $rule = [
            "uid"        => "nullable|integer",
            "phone_no"   => "nullable|numeric",
            "shop_id"    => "nullable|integer",
        ];

        $this->validation($param, $rule);
        return $this->usersService->getUserDetail($param);
    }

    //shop side  user
    public function getTodayUsers()
    {
        $param = [
            'shop_id' => Request::input('shop_id'),
        ];

        $rule = [
            'shop_id' => 'nullable|integer'
        ];

        $this->validation($param, $rule);
        return $this->usersService->getTodayUsers($param);
    }
    //确认顾客到店,或者取消
    public function checkUserOrderTime()
    {
        $param = [
            'order_time_id' => Request::input('order_time_id'),
            'status'        => Request::input('status'),
        ];
        $rule = [
            'order_time_id' => 'required|integer',
            'status' => 'required|numeric',
        ];

        $this->validation($param, $rule);
        return $this->usersService->checkUserOrderTime($param);
    }

    //获取用户预约情况
    public function getOrderTime()
    {
        $param = [
            "uid"        => Request::input('uid'),
            'emp_id'     => Request::input('emp_id'),
            'status'     => Request::input('status'),
            'shop_id'    => Request::input('shop_id'),
            'start_time' => Request::input('start_time'),
            'end_time'   => Request::input('end_time')
        ];

        return $this->usersService->getOrderTime($param);
    }

    //获取门店预约看板接口
    public function getOrderTimeView()
    {
        $param = [
            'shop_id'    => Request::input('shop_id'),
            'start_time' => Request::input('start_time'),
            'end_time'   => Request::input('end_time')
        ];

        return $this->usersService->getOrderTimeView($param);
    }


}
