<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Request;

use App\Services\AuthService;
class EmpLoginController extends Controller
{

    protected $authService;


    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(){

        $param = [
            'user'     => Request::input('user'),
            'password' => Request::input('password'),
            'ip'       => Request::getClientIp()
        ];
        $rule = [
            'user'     => "required|string",
            'password' => "required|string",
        ];
        $this->validation($param, $rule);
        $result =  $this->authService->empLogin($param);

        if ($result['statusCode'] == '0') {
            Request::session()->put('emp', $result['data']);
        }
        return $result;
    }

    public function logout()
    {
        Request::session()->flush();
        return $this->success();
    }




}
