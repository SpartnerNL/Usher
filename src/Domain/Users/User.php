<?php namespace Maatwebsite\Usher\Domain\Users;

use Doctrine\ORM\Mapping as ORM;
use Illuminate\Contracts\Auth\Authenticatable;
use Doctrine\Common\Collections\ArrayCollection;
use Maatwebsite\Usher\Domain\Users\Bans\Bannable;
use Maatwebsite\Usher\Domain\Users\Traits\Roleable;
use Maatwebsite\Usher\Domain\Users\Traits\Timestamps;
use Maatwebsite\Usher\Contracts\Users\Embeddables\Name;
use Maatwebsite\Usher\Contracts\Users\Embeddables\Email;
use Maatwebsite\Usher\Domain\Users\Traits\RememberToken;
use Maatwebsite\Usher\Domain\Users\Suspends\Suspendable;
use Maatwebsite\Usher\Domain\Users\Traits\Authentication;
use Maatwebsite\Usher\Domain\Users\Events\UserRegistered;
use Maatwebsite\Usher\Domain\Permissions\PermissionTrait;
use Maatwebsite\Usher\Domain\Shared\Embeddables\UpdatedAt;
use Maatwebsite\Usher\Domain\Users\Activations\Activatable;
use Maatwebsite\Usher\Contracts\Users\Embeddables\Password;
use Maatwebsite\Usher\Domain\Users\Embeddables\RegisteredAt;
use Maatwebsite\Usher\Contracts\Users\User as UserInterface;
use Maatwebsite\Usher\Domain\Users\Events\UserUpdatedProfile;
use Maatwebsite\Usher\Domain\Users\Embeddables\SuspendedTill;
use Maatwebsite\Usher\Domain\Users\Activations\ActivationCode;
use Maatwebsite\Usher\Contracts\Permissions\PermissionInterface;
use Maatwebsite\Usher\Contracts\Users\Embeddables\HashedPassword;

/**
 * @ORM\MappedSuperclass
 * @ORM\HasLifecycleCallbacks()
 */
abstract class User implements UserInterface, Authenticatable, PermissionInterface
{

    /**
     * Traits
     */
    use Authentication,
        Roleable,
        RememberToken,
        PermissionTrait,
        Activatable,
        Bannable,
        Suspendable,
        Timestamps;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Embedded(class = "Maatwebsite\Usher\Domain\Users\Embeddables\Name", columnPrefix=false)
     * @var Name
     */
    protected $name;

    /**
     * @ORM\Embedded(class = "Maatwebsite\Usher\Domain\Users\Embeddables\Email", columnPrefix=false)
     * @var Email
     */
    protected $email;

    /**
     * @ORM\Embedded(class = "Maatwebsite\Usher\Domain\Users\Embeddables\HashedPassword", columnPrefix=false)
     * @var HashedPassword
     */
    protected $password;

    /**
     * Init User entity
     */
    public function __construct()
    {
        $this->roles = new ArrayCollection;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->setRegisteredAt(
            new RegisteredAt()
        );

        $this->setUpdatedAt(
            new UpdatedAt
        );

        $this->setActivationCode(
            ActivationCode::generate()
        );
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
        $this->setUpdatedAt(
            new UpdatedAt()
        );
    }

    /**
     * Register a new user
     * @param Name     $name
     * @param Email    $email
     * @param Password $password
     * @return $this
     */
    public function register(Name $name, Email $email, Password $password)
    {
        $this->setName($name);
        $this->setEmail($email);
        $this->setPassword($password);

        event(new UserRegistered($this));

        return $this;
    }

    /**
     * @param Name     $name
     * @param Email    $email
     * @param Password $password
     * @return $this
     */
    public function update(Name $name, Email $email, Password $password = null)
    {
        $this->setName($name);
        $this->setEmail($email);

        if ($password) {
            $this->setPassword($password);
        }

        event(new UserUpdatedProfile($this));

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
     * @return Name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param Name $name
     */
    public function setName(Name $name)
    {
        $this->name = $name;
    }

    /**
     * @return Email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param Email $email
     */
    public function setEmail(Email $email)
    {
        $this->email = $email;
    }

    /**
     * @return HashedPassword
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param Password $password
     */
    public function setPassword(Password $password)
    {
        $this->password = $password;
    }

    /**
     * @param $permissions
     * @return bool
     */
    public function hasAccess($permissions)
    {
        if (!is_array($permissions)) {
            $permissions = func_get_args();
        }

        $hasAccess = true;

        // Loop through user permissions
        foreach ($permissions as $permission) {

            // only check when the permission exists for this user
            if ($this->permissionExists($permission)) {

                // Check if as access
                $hasAccess = $this->getPermission($permission);

                // When user doesn't have access to one of the given permissions
                // Immediately deny access
                if (!$hasAccess) {
                    return false;
                }
            }
        }

        // If user doesn't have enough permissions
        // deny access
        if (!$hasAccess) {
            return false;
        }

        // Check if user has permission to one
        // of it's roles
        foreach ($this->getRoles() as $role) {
            if ($role->hasAccess($permissions)) {
                return true;
            }
        }

        return false;
    }
}
