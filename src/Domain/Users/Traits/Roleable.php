<?php namespace Maatwebsite\Usher\Domain\Users\Traits;

use Doctrine\Common\Collections\ArrayCollection;
use Maatwebsite\Usher\Contracts\Roles\Role;
use Maatwebsite\Usher\Domain\Users\Events\UserGotAssignedToRole;
use Maatwebsite\Usher\Domain\Users\Events\UserGotRemovedFromRole;

trait Roleable
{

    /**
     * @return ArrayCollection|\Maatwebsite\Usher\Contracts\Roles\Role[]
     */
    abstract public function getRoles();

    /**
     * @param ArrayCollection|Role[] $roles
     */
    abstract public function setRoles(ArrayCollection $roles);

    /**
     * @param Role $role
     */
    public function assignRole(Role $role)
    {
        if (!$this->getRoles()->contains($role)) {
            $this->getRoles()->add($role);

            event(new UserGotAssignedToRole($this, $role));
        }
    }

    /**
     * Check if user has certain role
     * @param $roleId
     * @return mixed
     */
    public function hasRole($roleId)
    {
        foreach ($this->getRoles() as $role) {
            if ($role->getId() == $roleId) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param Role $role
     */
    public function removeRole(Role $role)
    {
        if ($this->getRoles()->contains($role)) {
            $this->getRoles()->removeElement($role);

            event(new UserGotRemovedFromRole($this, $role));
        }
    }

    /**
     * Remove all roles
     */
    public function removeAllRoles()
    {
        $this->setRoles(new ArrayCollection);
    }
}
