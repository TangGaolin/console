<?php
/**
 * Created by PhpStorm.
 * User: jesse
 * Date: 16/9/7
 * Time: 17:43
 */
return [
    'STATUSCODE_SUCCESS'                   => 0,
    'STATUSCODE_FAILED'                    => 100,
    'STATUSCODE_ERROR'                     => 101,

    'STATUSCODE_NOTLOGIN'                  => 400,
    'STATUSCODE_NOTACCESS'                 => 401,//无权限
    'STATUSCODE_PASSWDERROR'               => 402,//用户名或密码错误
    'STATUSCODE_CAPTCHAERROR'                   => 403,//用户名或密码错误

    'STATUSCODE_USERERROR'                 => 501,//用户信息添加或者修改错误的

    'STATUSCODE_ITEMERROR'                 => 601,//项目信息添加或者修改错误的

    'MSG_NOT_LOGIN'                        => "登录信息失效，请重新登录",
    'MSG_PASSWDERROR'                      => "用户名或密码错误",
    'MSG_USERERROR_ADD'                    => "添加用户错误",
    'MSG_OK'                               => "OK",




];