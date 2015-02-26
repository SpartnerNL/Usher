<?php namespace Maatwebsite\Usher\Domain\Roles\Events;

use Maatwebsite\Usher\Contracts\Roles\Role;

class RoleWasCreated {

    /**
     * @var Role
     */
    public $role;

    /**
     * @param Role $role
     */
    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    /**
     * @return Role
     */
    public function getRole()
    {
        return $this->role;
    }
}
