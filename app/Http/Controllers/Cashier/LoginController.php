<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use Request;

use App\Services\AuthService;
class LoginController extends Controller
{

    protected $request;

    protected $authService;


    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(){

        $param = [
            'user' => Request::input('user'),
            'password' => Request::input('password'),
            'ip' => Request::getClientIp()
        ];

        $result =  $this->authService->login($param);

        if ($result['statusCode'] == '0') {
            Request::session()->put('cashier', $result['data']);
            unset($result['data']['emp_id']);
        }
        return $result;
    }

    public function logout()
    {
        Request::session()->flush();
        return $this->success();
    }




}
