<?php namespace Maatwebsite\Usher\Domain\Users;

use Doctrine\ORM\Mapping as ORM;
use Maatwebsite\Usher\Domain\Users\Activations\Activatable;
use Maatwebsite\Usher\Domain\Users\Activations\ActivationCode;
use Maatwebsite\Usher\Domain\Users\Events\UserRegistered;
use Maatwebsite\Usher\Domain\Users\Events\UserUpdatedProfile;
use Maatwebsite\Usher\Traits\RememberToken;
use Maatwebsite\Usher\Contracts\Roles\Role;
use Maatwebsite\Usher\Traits\Authentication;
use Illuminate\Contracts\Auth\Authenticatable;
use Doctrine\Common\Collections\ArrayCollection;
use Maatwebsite\Usher\Contracts\Users\Embeddables\Name;
use Maatwebsite\Usher\Domain\Users\Events\UserGotBanned;
use Maatwebsite\Usher\Domain\Users\Embeddables\BannedAt;
use Maatwebsite\Usher\Contracts\Users\Embeddables\Email;
use Maatwebsite\Usher\Domain\Permissions\PermissionTrait;
use Maatwebsite\Usher\Domain\Shared\Embeddables\UpdatedAt;
use Maatwebsite\Usher\Domain\Users\Events\UserGotSuspended;
use Maatwebsite\Usher\Contracts\Users\Embeddables\Password;
use Maatwebsite\Usher\Domain\Users\Embeddables\RegisteredAt;
use Maatwebsite\Usher\Contracts\Users\User as UserInterface;
use Maatwebsite\Usher\Domain\Users\Embeddables\SuspendedTill;
use Maatwebsite\Usher\Contracts\Users\Embeddables\LastLoginAt;
use Maatwebsite\Usher\Contracts\Users\Embeddables\LastAttemptAt;
use Maatwebsite\Usher\Contracts\Permissions\PermissionInterface;
use Maatwebsite\Usher\Domain\Users\Events\UserGotAssignedToRole;
use Maatwebsite\Usher\Domain\Users\Events\UserGotRemovedFromRole;
use Maatwebsite\Usher\Contracts\Users\Embeddables\HashedPassword;
use Maatwebsite\Usher\Contracts\Users\Embeddables\BannedAt as BannedAtInterface;
use Maatwebsite\Usher\Contracts\Shared\Embeddables\UpdatedAt as UpdatedAtInterface;
use Maatwebsite\Usher\Contracts\Users\Embeddables\RegisteredAt as RegisteredAtInterface;
use Maatwebsite\Usher\Contracts\Users\Embeddables\SuspendedTill as SuspendTillInterface;

/**
 * @ORM\MappedSuperclass
 * @ORM\HasLifecycleCallbacks()
 */
abstract class User implements UserInterface, Authenticatable, PermissionInterface
{

    /**
     * Traits
     */
    use Authentication, RememberToken, PermissionTrait, Activatable;

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
     * @ORM\Embedded(class = "Maatwebsite\Usher\Domain\Users\Embeddables\LastAttemptAt", columnPrefix=false)
     * @var LastAttemptAt
     */
    protected $last_attempt_at = null;

    /**
     * @ORM\Embedded(class = "Maatwebsite\Usher\Domain\Users\Embeddables\LastLoginAt", columnPrefix=false)
     * @var LastLoginAt
     */
    protected $last_login_at = null;

    /**
     * @ORM\Embedded(class = "Maatwebsite\Usher\Domain\Users\Embeddables\SuspendedTill", columnPrefix=false)
     * @var SuspendedTillInterface
     */
    protected $suspended_till = null;

    /**
     * @ORM\Embedded(class = "Maatwebsite\Usher\Domain\Users\Embeddables\BannedAt", columnPrefix=false)
     * @var BannedAtInterface
     */
    protected $banned_at = null;

    /**
     * @ORM\Embedded(class = "Maatwebsite\Usher\Domain\Users\Embeddables\RegisteredAt", columnPrefix=false)
     * @var RegisteredAt
     */
    protected $registered_at = null;

    /**
     * @ORM\Embedded(class = "Maatwebsite\Usher\Domain\Shared\Embeddables\UpdatedAt", columnPrefix=false)
     * @var UpdatedAt
     */
    protected $updated_at = null;

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
            new RegisteredAt
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
            new UpdatedAt
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

    /**
     * @return LastAttemptAt
     */
    public function getLastAttemptAt()
    {
        return $this->last_attempt_at;
    }

    /**
     * @param LastAttemptAt $last_attempt_at
     */
    public function setLastAttemptAt(LastAttemptAt $last_attempt_at)
    {
        $this->last_attempt_at = $last_attempt_at;
    }

    /**
     * @return LastLoginAt
     */
    public function getLastLoginAt()
    {
        return $this->last_login_at;
    }

    /**
     * @param LastLoginAt $last_login_at
     */
    public function setLastLoginAt(LastLoginAt $last_login_at)
    {
        $this->last_login_at = $last_login_at;
    }

    /**
     * @return SuspendTillInterface
     */
    public function getSuspendedTill()
    {
        return $this->suspended_till;
    }

    /**
     * @param SuspendTillInterface $suspended_till
     */
    public function setSuspendedTill(SuspendTillInterface $suspended_till)
    {
        $this->suspended_till = $suspended_till;
    }

    /**
     * Check if is suspended
     * @return bool
     */
    public function isSuspended()
    {
        return !$this->getSuspendedTill()->inPast();
    }

    /**
     * Suspend for x minutes
     * @param int $minutes
     * @return mixed
     */
    public function suspend($minutes = 15)
    {
        $this->setSuspendedTill(
            SuspendedTill::addMinutes($minutes)
        );

        event(new UserGotSuspended($this));
    }

    /**
     * @return mixed
     */
    public function unsetSuspended()
    {
        $this->suspended_till = null;
    }

    /**
     * @return BannedAtInterface
     */
    public function getBannedAt()
    {
        return $this->banned_at;
    }

    /**
     * @param BannedAtInterface $banned_at
     */
    public function setBannedAt(BannedAtInterface $banned_at)
    {
        $this->banned_at = $banned_at;
    }

    /**
     * Check if is banned
     * @return bool
     */
    public function isBanned()
    {
        return $this->getBannedAt() && !is_null($this->getBannedAt()->getDate())
            ? true
            : false;
    }

    /**
     * Ban user
     * @return mixed
     */
    public function ban()
    {
        $this->setBannedAt(
            new BannedAt
        );

        event(new UserGotBanned($this));
    }

    /**
     * @return void
     */
    public function unsetBan()
    {
        $this->banned_at = null;
    }

    /**
     * @return RegisteredAt
     */
    public function getRegisteredAt()
    {
        return $this->registered_at;
    }

    /**
     * @param RegisteredAtInterface $registered_at
     */
    public function setRegisteredAt(RegisteredAtInterface $registered_at)
    {
        $this->registered_at = $registered_at;
    }

    /**
     * @return UpdatedAt
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param UpdatedAtInterface $updated_at
     */
    public function setUpdatedAt(UpdatedAtInterface $updated_at)
    {
        $this->updated_at = $updated_at;
    }
}
