<?php
namespace App\Repositories\Users;

use App\Models\Users;
use DB;

class UsersRepository implements UsersRepositoryInterface
{

    protected $usersModel;

    public function __construct(Users $users)
    {
        $this->usersModel = $users;
    }

    public function addUser($userData)
    {
        return $this->usersModel->insert($userData);
    }

    public function getUserList($whereParam)
    {
        $select = $this->usersModel->select("uid", "user_name", "phone_no", "user_degree", "emp_id", "shop_id", "remark");

        !empty($whereParam['shop_id']) && $select = $select->where("shop_id", "=", $whereParam["shop_id"]);
        !empty($whereParam['phone_no']) && $select = $select->where("phone_no", "=", $whereParam["phone_no"]);
        !empty($whereParam['user_name']) && $select = $select->where("user_name", "like", $whereParam["user_name"].'%');

        $countSelect = $select;
        $count       = $countSelect->count();
        $res         = $select->skip(($whereParam['cur_page']-1) * $whereParam['limit'])->take($whereParam['limit'])->get();

        return [
            'totalSize' => $count,
            'data'      => $res,
        ];
    }

    public function getUserInfo($user)
    {
        $result = $this->usersModel->where($user)->first();
        return $result ? $result->toArray() : false;
    }

    public function updateUser($uid, $userData)
    {
        return $this->usersModel->where('uid','=', $uid)->update($userData);
    }


}
