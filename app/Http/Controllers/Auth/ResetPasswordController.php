<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Request;

use App\Services\AuthService;
class ResetPasswordController extends Controller
{

    protected $authService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }


    public function resetCashierPassword(){
        $param = [
            'current_password'  => Request::input('current_password'),
            'new_password'      => Request::input('new_password'),
            'check_new_password'=> Request::input('check_new_password'),
            'ip'                => Request::getClientIp()
        ];
        $rule = [
            'current_password'     => "required|string",
            'new_password'         => "required|string",
            'check_new_password'   => "required|string",
        ];
        $this->validation($param, $rule);
        $param['emp_id'] = $this->getCashierId();
        $result =  $this->authService->resetPassword($param);
        return $result;
    }

    public function resetAdminPassword() {
        $param = [
            'current_password'  => Request::input('current_password'),
            'new_password'      => Request::input('new_password'),
            'check_new_password'=> Request::input('check_new_password'),
            'ip'                => Request::getClientIp()
        ];
        $rule = [
            'current_password'     => "required|string",
            'new_password'         => "required|string",
            'check_new_password'   => "required|string",
        ];
        $this->validation($param, $rule);
        $param['emp_id'] = $this->getAid();
        $result =  $this->authService->resetPassword($param);
        return $result;
    }

    public function resetEmpPassword() {
        $param = [
            'current_password'  => Request::input('current_password'),
            'new_password'      => Request::input('new_password'),
            'check_new_password'=> Request::input('check_new_password'),
            'ip'                => Request::getClientIp()
        ];
        $rule = [
            'current_password'     => "required|string",
            'new_password'         => "required|string",
            'check_new_password'   => "required|string",
        ];
        $this->validation($param, $rule);
        $param['emp_id'] = $this->getCashierId();
        $result =  $this->authService->resetPassword($param);
        return $result;
    }

}
