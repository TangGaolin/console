<?php
/**
 * Created by PhpStorm.
 * User: gaolintang
 * Date: 2017/8/9
 * Time: 上午10:01
 *
 * Desc: 常用方法库，可全局调用
 */

function checkParam($param, $key)
{
    return isset($param[$key]) && $param[$key];
}

function success($data = null)
{
    $returnData = [
        'statusCode' => config('response_code.STATUSCODE_SUCCESS'),
        'msg'        => config('response_code.MSG_OK'),
        'success'    => true
    ];
    $data && $returnData['data'] = $data;
    return response()->json($returnData);
}

function fail($code, $msg)
{
    return [
        'statusCode' => $code,
        'msg'  => $msg,
        'success' => false
    ];
}

