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
    public function __construct(UsersAccountRepositoryInterface $usersAccountRepository)
    {
        $this->usersAccountRepository = $usersAccountRepository;
    }


    public function getShopDataView($param)
    {
        $param['year']  = $param['year'] ? $param['year'] : date('Y');
        $param['mouth'] = $param['mouth'] ? $param['mouth'] : date('m');
        $param['day']   =  date('d');

        $shopDatas = [];
        for($day = 1; $day <= date('t'); $day++){
            if($day <= $param['day']){
                $data['day'] = $day;
                $data['yeji'] = $this->getYejiData($param['year'], $param['mouth'], $day, $param['shop_id']);
                $data['xiaohao'] = $this->getXiaohaoData($param['year'], $param['mouth'], $day, $param['shop_id']);
                $shopDatas[] = $data;
            }else{
                $data['day'] = $day;
                $data['yeji'] = 0;
                $data['xiaohao'] = 0;
                $shopDatas[] = $data;
            }
        }

        return [
            'statusCode' => config('response_code.STATUSCODE_SUCCESS'),
            'msg'        => config('response_code.MSG_OK'),
            'success'    => true,
            'data'       => $shopDatas
        ];
    }

    protected function getYejiData($year, $mouth, $day, $shop_id)
    {
        $redis = PRedis::connection();
        $redis_key = "shop_yeji:"  . $year . ':' . $mouth . ':' . $shop_id;
        $data  = $redis->hget($redis_key, $day);
        if(!$data){
            $data = $this->countYejiData($year, $mouth, $day, $shop_id);
            $redis->hset($redis_key, $day, $data);
        }
        return $data;
    }

    protected function getXiaohaoData($year, $mouth, $day, $shop_id)
    {
        $redis = PRedis::connection();
        $redis_key = "shop_xiaohao:"  . $year . ':' . $mouth . ':' . $shop_id;
        $data  = $redis->hget($redis_key, $day);
        if(!$data){
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