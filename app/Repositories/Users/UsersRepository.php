<?php
namespace App\Repositories\Users;

use App\Models\Users;
use DB;

class UsersRepository implements UsersRepositoryInterface
{

    protected $users;

    public function __construct(Users $users)
    {
        $this->users = $users;
    }

    public function addUser($userData)
    {
        return $this->users->insert($userData);
    }

    public function getUserList($whereData)
    {
        // TODO: Implement getUserList() method.



    }

    public function getUserInfo($user)
    {
        $result = $this->users->where($user)->first();
        return $result ? $result->toArray() : false;
    }

    public function updateUser($uid, $userData)
    {
        return $this->users->where('uid','=', $uid)->update($userData);
    }


}
