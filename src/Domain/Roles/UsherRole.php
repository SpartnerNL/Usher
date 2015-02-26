<?php namespace Maatwebsite\Usher\Domain\Roles;

use Doctrine\ORM\Mapping as ORM;
use Maatwebsite\Usher\Contracts\Roles\Role as RoleInterface;

/**
 * @ORM\Entity(repositoryClass="Maatwebsite\Usher\Infrastructure\Roles\DoctrineRoleRepository")
 * @ORM\Table(name="roles")
 * @ORM\HasLifecycleCallbacks()
 */
class UsherRole extends Role implements RoleInterface
{

    /**
     * @ORM\ManyToMany(targetEntity="Maatwebsite\Usher\Domain\Users\UsherUser", mappedBy="roles")
     * @var ArrayCollection|\Maatwebsite\Usher\Domain\Users\UsherUser[]
     **/
    protected $users;

    /**
     * @return ArrayCollection
     */
    public function getUsers()
    {
        return $this->users;
    }
}
