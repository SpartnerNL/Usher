<?php namespace Maatwebsite\Usher\Domain\Roles;

use Doctrine\ORM\Mapping as ORM;
use Maatwebsite\Usher\Domain\Shared\Timestamps;
use Doctrine\Common\Collections\ArrayCollection;
use Maatwebsite\Usher\Domain\Permissions\PermissionTrait;
use Maatwebsite\Usher\Domain\Roles\Events\RoleWasCreated;
use Maatwebsite\Usher\Domain\Roles\Events\RoleWasUpdated;
use Maatwebsite\Usher\Contracts\Roles\Role as RoleInterface;
use Maatwebsite\Usher\Contracts\Permissions\PermissionInterface;

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
     * Register a new user
     * @param       $name
     * @param array $permissions
     * @return $this
     */
    public function create($name, array $permissions = array())
    {
        $this->setName($name);
        $this->setPermissions($permissions);

        event(new RoleWasCreated($this));

        return $this;
    }

    /**
     * @param Name  $name
     * @param array $permissions
     * @return $this
     */
    public function update($name, array $permissions = array())
    {
        $this->setName($name);
        $this->setPermissions($permissions);

        event(new RoleWasUpdated($this));

        return $this;
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
}
