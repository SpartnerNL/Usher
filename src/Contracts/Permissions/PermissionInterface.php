<?php namespace Maatwebsite\Usher\Contracts\Permissions;

interface PermissionInterface
{

    /**
     * @param $permissions
     * @return bool
     */
    public function hasAccess($permissions);

    /**
     * @param array $permissions
     * @return bool
     */
    public function checkPermissions(array $permissions = array());

    /**
     * @return array
     */
    public function getPermissions();

    /**
     * @param mixed $permissions
     */
    public function setPermissions(array $permissions = array());

    /**
     * @param      $key
     * @param bool $default
     * @return bool
     */
    public function getPermission($key, $default = false);

    /**
     * @param      $key
     * @return bool
     */
    public function permissionExists($key);

    /**
     * @param $key
     * @param $value
     */
    public function addPermission($key, $value);

    /**
     * @param $key
     */
    public function removePermission($key);
}
