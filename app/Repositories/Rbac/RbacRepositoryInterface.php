<?php
namespace App\Repositories\Rbac;

interface RbacRepositoryInterface
{

    public function getRoleByAdminId($adminId);
    public function getRoleByAdminIds($adminIds);

    public function getAccessByRole($roleId);

    public function getRole($roleId);

    public function getRoleAll();

    public function updateRbacRoleUser($aid, $roleId);

    public function getRoleByName($roleName);

    public function insertRole($roleName);

    public function replaceIntoRoleAccess($roleId, $resource, $private_node);

    public function disableRoleAccess($roleId);

    public function insertRbacRoleUser($aid, $roleId);
}
