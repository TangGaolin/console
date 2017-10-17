<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\RbacService;
use Gregwar\Captcha\CaptchaBuilder;
use Request;

use App\Services\AuthService;
class AdminAuthController extends Controller
{

    protected $authService;
    protected $rbacService;


    public function __construct(AuthService $authService, RbacService $rbacService)
    {
        $this->authService = $authService;
        $this->rbacService = $rbacService;
    }

    public function login(){

        $param = [
            'user'     => Request::input('user'),
            'password' => Request::input('password'),
            'captcha'  => Request::input('captcha'),
            'ip'       => Request::getClientIp()
        ];

        $rule = [
            'user'     => "required|string",
            'password' => "required|string",
            'captcha'  => "required|string",
        ];
        $this->validation($param, $rule);

        //如果验证码不正确
        if(strtolower(Request::session()->get('phrase')) != strtolower($param['captcha'])) {
            Request::session()->forget('phrase');
            Request::session()->save();
            return fail(403,'验证码不正确');
        }
        $result =  $this->authService->login($param);
        if ($result['statusCode'] == '0') {
            Request::session()->put('admin', $result['data']);
        }
        return $result;
    }

    //后端管理登录，提供验证码
    public function captcha()
    {
        $builder = new CaptchaBuilder;
        $builder->build();
        Request::session()->put('phrase', $builder->getPhrase());
        return response($builder->output())->header('Content-Type', 'image/jpeg');
    }

    public function logout()
    {
        Request::session()->flush();
        return $this->success();
    }


    /**
     * 创建角色
     * @return array
     */
    public function addRole()
    {
        $param = [
            'role_name' => Request::input('role_name'),
        ];

        $rule = [
            'role_name' => 'required|string',
        ];

        $this->validation($param, $rule);

        $data = $this->rbacService->addRole($param['role_name']);
        return $data;
    }

    /**
     * 获取角色列表
     * @return array
     */
    public function getRoleList()
    {
        $data = $this->rbacService->getRoleList();

        return $data;
    }

    public function getNode()
    {
        $aid = $this->getAid();
        $data = $this->rbacService->getNode($aid);
        return $data;
    }

    public function roleAccess()
    {
        $param = [
            'role_id' => Request::input('role_id'),
        ];

        $rule = [
            'role_id' => 'required|integer',
        ];
        $this->validation($param, $rule);
        $data = $this->rbacService->roleAccess($param['role_id']);
        return $data;
    }

    public function modifyRoleAccess()
    {
        $param = [
            'resource' => Request::input('resource'),
            'role_id'  => Request::input('role_id')
        ];

        $rule = [
            'resource' => 'required|array',
            'role_id'  => 'required|Integer'
        ];

        $this->validation($param, $rule);

        $data = $this->rbacService->modifyRoleAccess($param['resource'], $param['role_id']);
        return $data;
    }

    public function disableRole()
    {
        $param = [
            'role_id'  => Request::input('role_id')
        ];

        $rule = [
            'role_id'  => 'required|Integer'
        ];

        $this->validation($param, $rule);

        $data = $this->rbacService->disableRole($param['role_id']);
        return $data;
    }


    /**
     * 创建帐号
     * @return array
     */
    public function openAccount()
    {
        $param = [
            'emp_name'       => Request::input('emp_name'),
            'phone_no'       => Request::input('phone_no'),
            'role_id'        => Request::input('role_id')
        ];

        $rule = [
            'emp_name'      => 'required|string',
            'phone_no'      => 'required|string',
            'role_id'        => 'required|Integer',
        ];

        $this->validation($param, $rule);
        $param['is_admin'] = 1; //为后台管理员账户
        $data = $this->rbacService->openAccount($param);
        return $data;
    }


    /*
     * 获取管理账号
     * */
    public function getAccountList()
    {
        $param = [
            "emp_name_phone" => Request::input('emp_name_phone'),
            'cur_page'  => Request::input('cur_page', 1),
            'limit'     => Request::input('limit', 15)
        ];
        $rule = [
            "emp_name_phone" => "nullable|string",
            "cur_page"   => "integer",
            "limit"      => "integer"
        ];
        $this->validation($param, $rule);

        $data = $this->rbacService->accountList($param);
        return $data;
    }

    /*
     * 删除帐号
     */
    public function disableAccount()
    {
        $param = [
            'emp_id'     => Request::input('emp_id'),
        ];
        $rule = [
            'emp_id' => 'required|Integer'
        ];

        $this->validation($param, $rule);
        $param['aid'] = $this->getAid();
        $data = $this->rbacService->disableAccount($param['emp_id'], $param['aid']);

        return $data;
    }








}
