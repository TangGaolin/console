<?php
namespace App\Repositories\Rbac;
use App\Models\RbacRoleAccess;
use App\Models\RbacRoleModels;
use App\Models\RbacRoleUser;
use DB;

class RbacRepository implements RbacRepositoryInterface
{

    protected $rbacRoleUser;

    protected $rbacRoleAccess;

    protected $rbacRoleModels;

    public function __construct(
        RbacRoleUser $rbacRoleUser,
        RbacRoleAccess $rbacRoleAccess,
        RbacRoleModels $rbacRoleModels
    )
    {
        $this->rbacRoleUser   = $rbacRoleUser;
        $this->rbacRoleAccess = $rbacRoleAccess;
        $this->rbacRoleModels = $rbacRoleModels;
    }

    public function getRoleByAdminId($adminId)
    {
        $result = $this->rbacRoleUser->where(['aid' => $adminId])->first();

        return $result ? $result->toArray() : false;
    }

    public function getRoleByAdminIds($adminIds)
    {
        $result = $this->rbacRoleUser->whereIn('aid',$adminIds)->get();

        return $result ? $result->toArray() : [];
    }

    public function getAccessByRole($roleId)
    {
        $result = $this->rbacRoleAccess->where('role_id', $roleId)->get();

        return $result ? $result->toArray() : false;
    }

    public function getRole($roleId)
    {
        $result = $this->rbacRoleModels->where('role_id', $roleId)->first();

        return $result ? $result->toArray() : false;
    }


    public function getRoleByName($roleName)
    {
        $result = $this->rbacRoleModels->where('role_name', $roleName)->first();

        return $result ? $result->toArray() : false;
    }

    public function getRoleAll()
    {
        $result = $this->rbacRoleModels->where('status', '1')->get();

        return $result ? $result->toArray() : false;
    }

    public function updateRbacRoleUser($aid, $roleId)
    {
        $roleUserData = $this->rbacRoleUser->where('aid', $aid)->first();
        if ($roleUserData) {
            $result = $this->rbacRoleUser->where('aid', $aid)->update([
                'role_id' => $roleId
            ]);
        } else {
            $result = $this->rbacRoleUser->create([
                'aid'     => $aid,
                'role_id' => $roleId
            ]);
        }

        return $result;
    }

    public function insertRbacRoleUser($aid, $roleId)
    {
        $result = $this->rbacRoleUser->firstOrCreate([
            'aid'     => $aid,
            'role_id' => $roleId
        ]);

        return $result;
    }

    //新增权限角色
    public function insertRole($roleName)
    {
        $result = $this->rbacRoleModels->insertGetId([
            'role_name' => $roleName
        ]);
        return $result;
    }

    //更新权限信息
    public function replaceIntoRoleAccess($roleId, $resource, $private_node)
    {
        $query = function () use ($roleId, $resource, $private_node) {
            $this->rbacRoleAccess->where('role_id', $roleId)->delete();
            foreach ($private_node as $k => $firstv) {
                foreach ($firstv['child'] as $secondk => $secondv) {
                    foreach ($secondv['child'] as $thirdk => $thirdv) {
                        if (in_array($thirdv['node_id'], $resource)) {
                            $path = [$firstv['node_id'], $secondv['node_id'], $thirdv['node_id']];
                            $this->rbacRoleAccess->insert([
                                'role_id'  => $roleId,
                                'resource' => json_encode($thirdv['resource'], JSON_UNESCAPED_UNICODE),
                                'path'     => json_encode($path)
                            ]);
                        }
                    }
                }
            }
        };

        DB::transaction($query);
        return true;
    }
    //禁用角色
    public function disableRoleAccess($roleId)
    {
        $result = $this->rbacRoleModels->where('role_id', $roleId)->update([
            'status' => 0
        ]);
        return $result;
    }
}
