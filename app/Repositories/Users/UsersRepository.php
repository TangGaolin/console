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
        if(isset($userData['birthday']) && "" == $userData['birthday']) {
            unset($userData['birthday']);
        }
        return $this->usersModel->insert($userData);
    }

    public function getUserList($whereParam)
    {
        $select = $this->usersModel->select("uid", "user_name", "phone_no", "user_degree", "emp_id", "shop_id", "remark", "add_time");

        checkParam($whereParam,'shop_id') && $select = $select->where("shop_id", "=", $whereParam["shop_id"]);
        checkParam($whereParam,'emp_id') && $select = $select->where("emp_id", "=", $whereParam["emp_id"]);
        checkParam($whereParam,'phone_no') && $select = $select->where("phone_no", "=", $whereParam["phone_no"]);
        checkParam($whereParam,'user_name') && $select = $select->where("user_name", "like", $whereParam["user_name"].'%');

        $countSelect = $select;
        $count       = $countSelect->count();
        $res         = $select->skip(($whereParam['cur_page']-1) * $whereParam['limit'])->take($whereParam['limit'])->get();

        return [
            'totalSize' => $count,
            'data'      => $res->toArray(),
        ];
    }

    public function getUserNum($whereParam)
    {
        $select = $this->usersModel;
        checkParam($whereParam,'emp_id') && $select = $select->where("emp_id", "=", $whereParam["emp_id"]);
        return $select->count();
    }


    public function getUserInfo($user)
    {
        $result = $this->usersModel->where($user)->first();
        return $result ? $result->toArray() : false;
    }

    public function getUserInfoByIds($u_ids)
    {
        $result = $this->usersModel->whereIn('uid',$u_ids)->get();
        return $result ? $result->toArray() : false;
    }

    public function updateUser($uid, $userData)
    {
        return $this->usersModel->where('uid','=', $uid)->update($userData);
    }


}
