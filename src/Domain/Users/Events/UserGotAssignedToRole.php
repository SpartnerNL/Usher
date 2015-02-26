<?php namespace Maatwebsite\Usher\Domain\Users\Events;

use Maatwebsite\Usher\Contracts\Roles\Role;
use Maatwebsite\Usher\Contracts\Users\User;

class UserGotAssignedToRole
{

    /**
     * @var User
     */
    public $user;

    /**
     * @var Role
     */
    public $role;

    /**
     * @param User $user
     * @param Role $role
     */
    public function __construct(User $user, Role $role)
    {
        $this->user = $user;
        $this->role = $role;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return Role
     */
    public function getRole()
    {
        return $this->role;
    }
}
