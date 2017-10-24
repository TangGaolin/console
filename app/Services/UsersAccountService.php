<?php
/**
 * Created by PhpStorm.
 * User: gaolintang
 * Date: 2017/5/23
 * Time: 下午3:27
 */
namespace App\Services;

use App\Repositories\Employee\EmployeeRepositoryInterface;
use App\Repositories\Users\UsersAccountRepositoryInterface;
use App\Repositories\Users\UsersRepositoryInterface;


Class UsersAccountService
{

    protected $usersRepository;
    protected $usersAccountRepository;
    public function __construct(UsersRepositoryInterface $usersRepository, UsersAccountRepositoryInterface $usersAccountRepository)
    {
        $this->usersRepository = $usersRepository;
        $this->usersAccountRepository = $usersAccountRepository;
    }


    public function getOrderList($param)
    {
        if($param['select_date']){
            $param['start_time'] = $param['select_date'];
            $param['end_time']   = $param['select_date'] . " 23:59:59";
        }
        if($param['date_range']) {
            $param['start_time'] = $param['date_range'][0];
            $param['end_time']   = $param['date_range'][1];
        }

        $orderList = $this->usersAccountRepository->getOrderList($param);

        //获取收银员信息
        $convert_cashiers = [];
        $convert_users = [];
        if($orderList['data']){
            $cashier_ids = array_column($orderList['data'],"cashier_id");
            $empRepository = app(EmployeeRepositoryInterface::class);
            $cashier_ids = array_unique($cashier_ids);
            $cashiers = $empRepository->getEmpDataByIds($cashier_ids);
            foreach ($cashiers as $cashier){
                $convert_cashiers[$cashier['emp_id']] = $cashier;
            }
            //若参数中没有uid条件参数，则就取用户信息
            if(!$param['uid']){
                $u_ids = array_column($orderList['data'],"uid");
                $u_ids = array_unique($u_ids);
                $useRepository = app(UsersRepositoryInterface::class);
                $users = $useRepository->getUserInfoByIds($u_ids);
                foreach ($users as $user){
                    $convert_users[$user['uid']] = $user;
                }
            }
        }

        //获取员工信息
        foreach ($orderList['data'] as &$order) {
            $order['cashier_name'] = $convert_cashiers[$order['cashier_id']]['emp_name'];
            $order['order_type_name'] = config('global.order_types')[$order['order_type']] ?? "其他";
            if($convert_users){
                $order['user_name'] = $convert_users[$order['uid']]['user_name'] ?? "散客";
            }
        }
        return [
            'statusCode' => config('response_code.STATUSCODE_SUCCESS'),
            'msg'        => config('response_code.MSG_OK'),
            'success'    => true,
            'data'       => $orderList
        ];
    }

    public function getItemList($param)
    {
        $orderList = $this->usersAccountRepository->getItemList($param);

        return [
            'statusCode' => config('response_code.STATUSCODE_SUCCESS'),
            'msg'        => config('response_code.MSG_OK'),
            'success'    => true,
            'data'       => $orderList
        ];
    }


    public function getUseOrderList($param)
    {
        if($param['select_date']){
            $param['start_time'] = $param['select_date'];
            $param['end_time']   = $param['select_date'] . " 23:59:59";
        }

        if($param['date_range']) {
            $param['start_time'] = $param['date_range'][0];
            $param['end_time']   = $param['date_range'][1];
        }
        $orderList = $this->usersAccountRepository->getUseOrderList($param);

        $convert_cashiers = [];
        $convert_users = [];
        if($orderList['data']){
            $cashier_ids = array_column($orderList['data'],"cashier_id");
            $empRepository = app(EmployeeRepositoryInterface::class);
            $cashier_ids = array_unique($cashier_ids);
            $cashiers = $empRepository->getEmpDataByIds($cashier_ids);
            foreach ($cashiers as $cashier){
                $convert_cashiers[$cashier['emp_id']] = $cashier;
            }

            //若参数中没有uid条件参数，则就回去用户信息
            if(!$param['uid']){
                $u_ids = array_column($orderList['data'],"uid");
                $u_ids = array_unique($u_ids);
                $useRepository = app(UsersRepositoryInterface::class);
                $users = $useRepository->getUserInfoByIds($u_ids);
                foreach ($users as $user){
                    $convert_users[$user['uid']] = $user;
                }
            }
        }

        //获取员工信息
        foreach ($orderList['data'] as &$order) {
            $order['cashier_name'] = $convert_cashiers[$order['cashier_id']]['emp_name'];
            if($convert_users){
                $order['user_name'] = $convert_users[$order['uid']]['user_name'] ?? "散客";
            }
        }

        return [
            'statusCode' => config('response_code.STATUSCODE_SUCCESS'),
            'msg'        => config('response_code.MSG_OK'),
            'success'    => true,
            'data'       => $orderList
        ];
    }

}