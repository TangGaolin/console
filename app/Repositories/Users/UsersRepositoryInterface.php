<?php
namespace App\Repositories\Users;

interface UsersRepositoryInterface
{
    public function addUser($userData);
    public function getUserList($whereData);
    public function getUserInfo($user);
    public function getUserInfoByIds($u_ids);
    public function updateUser($uid, $userData);
}
