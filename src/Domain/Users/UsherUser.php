<?php namespace Maatwebsite\Usher\Domain\Users;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Maatwebsite\Usher\Contracts\Users\User as UserInterface;

/**
 * @ORM\Entity(repositoryClass="Maatwebsite\Usher\Infrastructure\Users\DoctrineUserRepository")
 * @ORM\Table(name="users")
 * @ORM\HasLifecycleCallbacks()
 */
class UsherUser extends User implements UserInterface
{

    /**
     * @ORM\ManyToMany(targetEntity="Maatwebsite\Usher\Domain\Roles\UsherRole", inversedBy="users")
     * @ORM\JoinTable(name="user_roles",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")})
     * @var ArrayCollection|\Maatwebsite\Usher\Domain\Roles\UsherRole[]
     */
    protected $roles;

    /**
     * @return ArrayCollection|\Maatwebsite\Usher\Contracts\Roles\Role[]
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param array|\Maatwebsite\Usher\Contracts\Roles\Role[] $roles
     */
    public function setRoles(array $roles = array())
    {
        $this->roles = $roles;
    }
}
