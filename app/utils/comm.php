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

    !is_null($data) && $returnData['data'] = $data;
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

function isPhoneNo($phoneNo){
    return preg_match('/^1[3|4|5|7|8]\d{9}$/', $phoneNo) ? true : false;
}


function getTimeIndex($time) {
    $hour = substr($time, -8,2);
    if($hour < 8) {
        return 1;
    }else if(8 <= $hour && 10 > $hour) {
        return 2;
    }else if(10 <= $hour && 12 > $hour) {
        return 3;
    }else if(12 <= $hour && 14 > $hour) {
        return 4;
    }else if(14 <= $hour && 16 > $hour) {
        return 5;
    }else if(16 <= $hour && 18 > $hour) {
        return 5;
    }else{
        return 7;
    }
}