<?php namespace Maatwebsite\Usher\Contracts\Roles;

use Maatwebsite\Usher\Contracts\Users\User;

interface Role
{

    /**
     * @return mixed
     */
    public function getId();

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     */
    public function setName($name);

    /**
     * @return ArrayCollection
     */
    public function getUsers();

    /**
     * @param User $user
     */
    public function addUser(User $user);

    /**
     * @param User $user
     */
    public function removeUser(User $user);

    /**
     * @return array
     */
    public function getPermissions();

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
     * @param mixed $permissions
     */
    public function setPermissions(array $permissions = []);

    /**
     * @param $key
     * @param $value
     */
    public function addPermission($key, $value);
}
