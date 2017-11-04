<?php
/**
 * Created by PhpStorm.
 * User: gaolintang
 * Date: 2017/5/23
 * Time: 下午3:27
 */
namespace App\Services;

use App\Repositories\Users\UsersAccountRepositoryInterface;

Class AdminActionService
{

    protected $usersRepository;
    protected $usersAccountRepository;
    public function __construct(UsersAccountRepositoryInterface $usersAccountRepository)
    {
        $this->usersAccountRepository = $usersAccountRepository;
    }

    public function cancelOrderAction($param)
    {
        //检查单据详情
        $orderInfo = $this->usersAccountRepository->getOrderList(['order_id' => $param['order_id']]);
        if(!$orderInfo['data']) {
            return fail('604', '单据不存在');
        }
        if($orderInfo['data'][0]['pay_balance'] > 0 || $orderInfo['data'][0]['debt'] > 0) {
            return fail('605', '该单据不支持撤销');
        }
        //获取单据订单详情
        $orderItem = $this->usersAccountRepository->getItemListByOrderId($param['order_id']);

        //判断是否使用单据
        foreach ($orderItem as $item){
            if($item['used_times'] > 0) {
                return fail('605', '该单据不支持撤销');
            }
        }
        //删除单据
        $this->usersAccountRepository->cancelOrder($param);

        //记录删除单据的日志
        loggerInfo(
            'cancel-order-list.log',
            json_encode($orderInfo, JSON_UNESCAPED_UNICODE),
            \Monolog\Logger::INFO
        );
        return success();
    }

}