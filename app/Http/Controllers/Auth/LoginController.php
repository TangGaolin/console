<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Request;

use App\Services\AuthService;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    protected $request;

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

    public function login(){

        $param = [
            'user' => Request::input('user'),
            'password' => Request::input('password'),
            'ip' => Request::getClientIp()
        ];

        $result =  $this->authService->login($param);

        if ($result['statusCode'] == '0') {
            Request::session()->put('admin', $result['data']);
            unset($result['data']['emp_id']);
        }

        return $result;

    }


}
