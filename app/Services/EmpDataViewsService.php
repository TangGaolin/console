<?php
/**
 * Created by PhpStorm.
 * User: gaolintang
 * Date: 2017/5/23
 * Time: 下午3:27
 */
namespace App\Services;
use App\Repositories\Employee\EmpOrderRepositoryInterface;
use PRedis;

Class EmpDataViewsService
{
    public function __construct()
    {
    }


    public function getEmpDataView($param)
    {
        $param['year']  = $param['year'] ? $param['year'] : date('Y');
        $param['mouth'] = $param['mouth'] ? $param['mouth'] : date('m');
        $param['day']   =  date('d');

        $empDatas = [];
        $empDatas['yeji_sum'] = 0;
        $empDatas['xiaohao_sum'] = 0;
        $empDatas['fee_sum'] = 0;
        $empDatas['yeji_today'] = 0;
        $empDatas['xiaohao_today'] = 0;
        $empDatas['fee_today'] = 0;
        for($day = 1; $day <= date('t'); $day++){
            if($day <= $param['day']){
                $data['day'] = $day;
                $empData = $this->getEmpData($param['year'], $param['mouth'], $day, $param['emp_id']);
                $data['yeji'] = $empData['yeji'];
                $data['xiaohao'] = $empData['xiaohao'];
                $data['fee'] = $empData['fee'];
                $empDatas['yeji_sum'] += $data['yeji'];
                $empDatas['xiaohao_sum'] += $data['xiaohao'];
                $empDatas['fee_sum'] += $data['fee'];
                if($day == $param['day']){
                    $empDatas['yeji_today'] = $data['yeji'];
                    $empDatas['xiaohao_today'] = $data['xiaohao'];
                    $empDatas['fee_today'] = $data['fee'];
                }
                $empDatas['list'][] = $data;
            }else{
                $data['day'] = $day;
                $data['yeji'] = 0;
                $data['xiaohao'] = 0;
                $data['fee'] = 0;
                $empDatas['list'][] = $data;
            }
        }
        return [
            'statusCode' => config('response_code.STATUSCODE_SUCCESS'),
            'msg'        => config('response_code.MSG_OK'),
            'success'    => true,
            'data'       => $empDatas
        ];
    }

    protected function getEmpData($year, $mouth, $day, $emp_id)
    {
        $redis = PRedis::connection();
        $redis_key = "emp:"  . $year . ':' . $mouth . ':' . $emp_id;
        $data  = $redis->hget($redis_key, $day);
        if(!$data){
            $data = $this->countEmpData($year, $mouth, $day, $emp_id);
            $redis->hset($redis_key, $day, $data);
        }
        return json_decode($data, true);
    }

    public function countEmpData($year, $mouth, $day, $emp_id)
    {
        $empOrderRepository = app(EmpOrderRepositoryInterface::class);

        $whereParam['start_time'] = $year . "-" . $mouth . '-' .$day;
        $whereParam['end_time'] = $whereParam['start_time'] . ' 23:59:59';
        $whereParam['emp_id'] = $emp_id;
        $whereParam['limit'] = 1000;

        $orders = $empOrderRepository->getEmpOrderList($whereParam);
        $data['yeji'] = 0;
        $data['xiaohao'] = 0;
        $data['fee'] = 0;
        foreach ($orders['data'] as $order) {
            $data['yeji']    += $order['yeji'];
            $data['xiaohao'] += $order['xiaohao'];
            $data['fee']     += $order['fee'];
        }
        return json_encode($data, true);
    }

}