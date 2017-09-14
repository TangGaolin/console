<?php
/**
 * Created by PhpStorm.
 * User: gaolintang
 * Date: 2017/5/23
 * Time: 下午3:27
 */
namespace App\Services;
use App\Repositories\Users\UsersAccountRepositoryInterface;
use PRedis;


Class DataViewsService
{
    protected $usersAccountRepository;
    public function __construct()
    {
    }


    public function getShopDataView($param)
    {

        $param['year']  = $param['year'] ? $param['year'] : date('Y');
        $param['mouth'] = $param['mouth'] ? $param['mouth'] : date('m');

        $shopDatas = [];
        for($day = 1; $day <= date('t'); $day++){
            //初始化
            $data['day'] = $day;
            $data['yeji'] = 0;
            $data['xiaohao'] = 0;
            //判断当前天
            $currentDay = strtotime($param['year'] . "-" . $param['mouth'] . "-" . $day);
            if(strtotime($currentDay) > time()){
                $shopDatas[] = $data;
                continue;
            }
            $data['yeji'] = $this->getYejiData($param['year'], $param['mouth'], $day, $param['shop_id']);
            $data['xiaohao'] = $this->getXiaohaoData($param['year'], $param['mouth'], $day, $param['shop_id']);
            $shopDatas[] = $data;

        }

        return [
            'statusCode' => config('response_code.STATUSCODE_SUCCESS'),
            'msg'        => config('response_code.MSG_OK'),
            'success'    => true,
            'data'       => $shopDatas
        ];
    }

    public function getShopsDataView($param)
    {

        $shopsData = [];
        $whereParam['year'] = $param['year'];
        $whereParam['mouth'] = $param['mouth'];
        foreach ($param['shop_ids'] as $v){
            $whereParam['shop_id'] = $v;
            $res = $this->getShopDataView($whereParam);
            $shopsData[$v] = $res['data'];
        }

        return [
            'statusCode' => config('response_code.STATUSCODE_SUCCESS'),
            'msg'        => config('response_code.MSG_OK'),
            'success'    => true,
            'data'       => $shopsData
        ];
    }

    protected function getYejiData($year, $mouth, $day, $shop_id)
    {

        $mouth = str_pad($mouth,2,0, STR_PAD_LEFT);

        $redis = PRedis::connection();
        $redis_key = "shop_yeji:"  . $year . ':' . $mouth . ':' . $shop_id;
        $data  = $redis->hget($redis_key, $day);
        if(is_null($data)){
            $data = $this->countYejiData($year, $mouth, $day, $shop_id);
            $redis->hset($redis_key, $day, $data);
        }
        return $data;
    }

    protected function getXiaohaoData($year, $mouth, $day, $shop_id)
    {
        $mouth = str_pad($mouth,2,0, STR_PAD_LEFT);

        $redis = PRedis::connection();
        $redis_key = "shop_xiaohao:"  . $year . ':' . $mouth . ':' . $shop_id;
        $data  = $redis->hget($redis_key, $day);
        if(is_null($data)){
            $data = $this->countXiaohaoData($year, $mouth, $day, $shop_id);
            $redis->hset($redis_key, $day, $data);
        }
        return $data;
    }


    protected function countYejiData($year, $mouth, $day, $shop_id)
    {
        $usersAccountRepository = app(UsersAccountRepositoryInterface::class);

        $whereParam['start_time'] = $year . "-" . $mouth . '-' .$day;
        $whereParam['end_time'] = $whereParam['start_time'] . ' 23:59:59';
        $whereParam['shop_id'] = $shop_id;
        $whereParam['limit'] = 1000;

        $orders = $usersAccountRepository->getOrderList($whereParam);
        $data = 0;
        foreach ($orders['data'] as $order) {
            $data += $order['pay_money'];
        }
        return $data;
    }

    protected function countXiaohaoData($year, $mouth, $day, $shop_id)
    {
        $usersAccountRepository = app(UsersAccountRepositoryInterface::class);

        $whereParam['start_time'] = $year . "-" . $mouth . '-' .$day;
        $whereParam['end_time'] = $whereParam['start_time'] . ' 23:59:59';
        $whereParam['shop_id'] = $shop_id;
        $whereParam['limit'] = 1000;

        $orders = $usersAccountRepository->getUseOrderList($whereParam);
        $data = 0;
        foreach ($orders['data'] as $order) {
            $data += $order['use_money'];
        }
        return $data;
    }









}