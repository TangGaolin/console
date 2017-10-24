<?php
/**
 * Created by PhpStorm.
 * User: jesse
 * Date: 16/9/7
 * Time: 20:17
 */

namespace App\Services;


use App\Repositories\Employee\EmployeeRepositoryInterface;
use App\Repositories\Rbac\RbacRepositoryInterface;


class RbacService
{
    protected $rbacRepository;
    protected $adminRepository;
    protected $rbacnode;

    public function __construct(RbacRepositoryInterface $rbacRepository, EmployeeRepositoryInterface $adminRepository)
    {
        $this->rbacRepository  = $rbacRepository;
        $this->adminRepository = $adminRepository;
        $this->rbacnode        = config('rbac_node');
    }

    //获取权限节点
    public function getNode($adminId)
    {
        $adminInfo     = $this->adminRepository->getEmployeeInfo(['emp_id' => $adminId]);
        $roleData   = $this->rbacRepository->getRoleByAdminId($adminId);
        $accessData = $this->rbacRepository->getAccessByRole($roleData['role_id']);

        $sourceAdmin  = array_column($accessData, 'path');

        $existsSource = function ($nodeId) use ($sourceAdmin, $adminInfo) {
            if ($adminInfo['is_super_admin'] ) return true;
            foreach ($sourceAdmin as $v) {
                $source = json_decode($v);
                if (in_array($nodeId, $source)) {
                    return true;
                }
            }
            return false;
        };

        foreach ($this->rbacnode['private_node'] as $k => &$v) {
            $v['checked'] = $existsSource($v['node_id']) ? true : false;
            foreach ($v['child'] as $secondKey => &$secondValue) {
                $secondValue['checked'] = $existsSource($secondValue['node_id']) ? true : false;
                foreach ($secondValue['child'] as $thirdKey => &$thirdValue) {
                    $thirdValue['checked'] = $existsSource($thirdValue['node_id']) ? true : false;
                    unset($thirdValue['resource']);
                }
            }
        }
        return success($this->rbacnode['private_node']);
    }

    //创建新账号
    public function openAccount($param)
    {
        $role_id = $param['role_id'];
        unset($param['role_id']);
        $employeeData = $param;
        //判断角色是否存在
        $roleData = $this->rbacRepository->getRole($role_id);
        if (!$roleData) {
            return fail('702', "角色不存在!");
        }
        //设置初始化密码
        $employeeData['password'] = mt_rand(100000, 999999);
        //判断手机号码是否存已经存在
        $res = $this->adminRepository->getEmployeeInfo(['phone_no' => $employeeData['phone_no']]);
        if ($res) {
            //如果密码不为空
            if($res['password']){
                unset($employeeData['password']);
            }
            $this->adminRepository->updateEmployee($res['emp_id'], $employeeData);
            $admin_id = $res['emp_id'];
        }else{
            $employeeData['is_server'] = 0; // 默认为非服务人员
            $admin_id = $this->adminRepository->addEmployee($employeeData);
        }
        //关联角色表
        $this->rbacRepository->insertRbacRoleUser($admin_id, $role_id);
        return success();
    }

    //获取角色列表
    public function getRoleList()
    {
        $rbacData = $this->rbacRepository->getRoleAll();

        return success($rbacData);
    }

    /*
     * 获取帐号列表
     * @param $limit
     * @param $cur_page
     */
    public function accountList($param)
    {

        if (is_numeric($param['emp_name_phone'])) {
            $param['phone_no'] = $param['emp_name_phone'];
        } else {
            $param['emp_name'] = $param['emp_name_phone'];
        }

        $data   = $this->adminRepository->getAccountLimit($param);
        return success($data);
    }

    /*
     * 添加角色
     * @param $roleName
     */
    public function addRole($roleName)
    {
        $roleData = $this->rbacRepository->getRoleByName($roleName);
        if ($roleData) {
            return fail('701', '角色已经存在');
        }
        $this->rbacRepository->insertRole($roleName);
        return success();
    }

    //角色权限修改
    public function modifyRoleAccess($resource, $roleId)
    {
        //判断角色是否存在
        $roleData = $this->rbacRepository->getRole($roleId);
        if (!$roleData) {
            return fail('701', '角色不存在');
        }
        $this->rbacRepository->replaceIntoRoleAccess($roleId, $resource, $this->rbacnode['private_node']);

        return success();
    }

    //禁用角色
    public function disableRole($roleId)
    {
        //判断角色是否存在
        $roleData = $this->rbacRepository->getRole($roleId);
        if (!$roleData) {
            return fail('701', '角色不存在');
        }
        $this->rbacRepository->disableRoleAccess($roleId);
        return success();
    }

    //禁用账户
    public function disableAccount($emp_id, $aid)
    {
        //本人的账户不能删除
        if ($aid == $emp_id) {
            return fail('704', "本人账户不能删除");
        }
        $this->adminRepository->updateEmployee($emp_id, [
            'is_admin' => 0,
            'is_super_admin' => 0
        ]);
        return success();
    }

    /*
     * 获取角色的权限
     * @param $roleId
     */
    public function roleAccess($roleId)
    {
        //判断角色是否存在
        $roleData = $this->rbacRepository->getRole($roleId);
        if (!$roleData) {
            return fail('702','角色不存在');
        }

        $accessData = $this->rbacRepository->getAccessByRole($roleId);

        $sourceAdmin  = array_column($accessData, 'path');
        $existsSource = function ($nodeId) use ($sourceAdmin) {
            foreach ($sourceAdmin as $v) {
                $source = json_decode($v);
                if (in_array($nodeId, $source)) {
                    return true;
                }
            }
            return false;
        };

        foreach ($this->rbacnode['private_node'] as $k => &$v) {
            $v['checked'] = $existsSource($v['node_id']) ? true: false;
            foreach ($v['child'] as $secondKey => &$secondValue) {
                $secondValue['checked'] = $existsSource($secondValue['node_id']) ? true: false;
                foreach ($secondValue['child'] as $thirdKey => &$thirdValue) {
                    $thirdValue['checked'] = $existsSource($thirdValue['node_id']) ? true: false;
                    unset($thirdValue['resource']);
                }
            }
        }

        return success($this->rbacnode['private_node']);
    }
}
