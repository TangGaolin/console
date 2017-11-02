<?php
/**
 * Created by PhpStorm.
 * User: gaolintang
 * Date: 2017/5/23
 * Time: 下午3:27
 */
namespace App\Services;



use App\Repositories\Users\UsersAccountRepositoryInterface;
use App\Repositories\Users\UsersRepositoryInterface;

Class StoreDataService {


    protected $usersRepository;
    protected $usersAccountRepository;

    public function __construct(UsersRepositoryInterface $usersRepository, UsersAccountRepositoryInterface $usersAccountRepository)
    {
        $this->usersRepository = $usersRepository;
        $this->usersAccountRepository = $usersAccountRepository;
    }

    public function getStoreAllMoney($param)
    {
        //获取剩余余额（会员卡 产品卡 欠款）
        $data = $this->usersRepository->getUserMoney($param);
        //获取剩余卡项余额
        $itemData = $this->usersAccountRepository->getAllItemMoney($param);
        $data = array_merge($data, $itemData);
        return success($data);
    }

}