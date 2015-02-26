<?php namespace Maatwebsite\Usher\Domain\Roles;

use Doctrine\ORM\Mapping as ORM;
use Maatwebsite\Usher\Contracts\Permissions\PermissionInterface;
use Maatwebsite\Usher\Domain\Permissions\PermissionTrait;
use Maatwebsite\Usher\Traits\Timestamps;
use Maatwebsite\Usher\Contracts\Users\User;
use Doctrine\Common\Collections\ArrayCollection;
use Maatwebsite\Usher\Contracts\Roles\Role as RoleInterface;
use Maatwebsite\Usher\Domain\Users\Events\UserGotAssignedToRole;
use Maatwebsite\Usher\Domain\Users\Events\UserGotRemovedFromRole;

/**
 * @ORM\MappedSuperclass
 * @ORM\HasLifecycleCallbacks()
 */
abstract class Role implements RoleInterface, PermissionInterface
{

    /**
     * Traits
     */
    use PermissionTrait;

    /**
     * Traits
     */
    use Timestamps;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $name;

    /**
     * @internal $users
     */
    public function __construct()
    {
        $this->users = new ArrayCollection;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return ArrayCollection
     */
    abstract public function getUsers();

    /**
     * @param User $user
     */
    public function addUser(User $user)
    {
        $this->getUsers()->add($user);

        event(new UserGotAssignedToRole($user, $this));
    }

    /**
     * @param User $user
     */
    public function removeUser(User $user)
    {
        $this->getUsers()->removeElement($user);

        event(new UserGotRemovedFromRole($user, $this));
    }
}
