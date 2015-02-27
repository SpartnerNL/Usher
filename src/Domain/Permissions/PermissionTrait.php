<?php namespace Maatwebsite\Usher\Domain\Permissions;

trait PermissionTrait
{

    /**
     * @ORM\Column(type="json_array")
     * @var array
     */
    protected $permissions = array();

    /**
     * @param $permissions
     * @return bool
     */
    public function hasAccess($permissions)
    {
        if (!is_array($permissions)) {
            $permissions = func_get_args();
        }

        return $this->checkPermissions($permissions);
    }

    /**
     * @param array $permissions
     * @return bool
     */
    public function checkPermissions(array $permissions = array())
    {
        foreach ($permissions as $permission) {
            if (!$this->getPermission($permission)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return array
     */
    public function getPermissions()
    {
        return $this->permissions;
    }

    /**
     * @param mixed $permissions
     */
    public function setPermissions(array $permissions = array())
    {
        $this->permissions = $permissions;
    }

    /**
     * Return the permission value
     * @param      $key
     * @param bool $default
     * @return bool
     */
    public function getPermission($key, $default = null)
    {
        return $this->permissionExists($key) ? $this->permissions[$key] : $this->getDefaultPermission($default);
    }

    /**
     * @param null $default
     * @return bool|null
     */
    public function getDefaultPermission($default = null)
    {
        if (!is_null($default)) {
            return $default;
        }

        $strict = config('usher.permissions.strict', true);

        if($strict) {
            return false;
        }

        return false;
    }

    /**
     * @param      $key
     * @return bool
     */
    public function permissionExists($key)
    {
        return isset($this->permissions[$key]) ? true : false;
    }

    /**
     * @param $key
     * @param $value
     */
    public function addPermission($key, $value)
    {
        $this->permissions[$key] = $value;
    }

    /**
     * @param $key
     */
    public function removePermission($key)
    {
        if ($this->permissionExists($key)) {
            unset($this->permissions[$key]);
        }
    }
}
