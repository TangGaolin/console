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

function loggerInfo($path, $message, $level)
{
    $log = new \Monolog\Logger(config('app.name'));
    $log->pushHandler(
        new \Monolog\Handler\StreamHandler(
            storage_path('logs/'. $path),
            $level
        )
    );
    $log->addInfo($message);
}

function request_by_curl($remote_server, $post_string, $needLog = false) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $remote_server);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array ('Content-Type: application/json;charset=utf-8'));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($ch);
    curl_close($ch);
    //是否需要记录log
    if($needLog){
        $message = [
            'request_uri'    => $remote_server,
            'request_body'   => $post_string,
            'response_body'  => @json_decode($data, true) ?: $data
        ];

        //记录log
        loggerInfo(
            'servicelog.'.date('Y-m-d').'.log',
            json_encode($message, JSON_UNESCAPED_UNICODE),
            \Monolog\Logger::INFO
        );
    }
    return $data;
}




