<?php namespace Maatwebsite\Usher\Contracts\Users;

use Doctrine\Common\Collections\ArrayCollection;
use Maatwebsite\Usher\Contracts\Roles\Role;
use Maatwebsite\Usher\Contracts\Users\Embeddables\Name;
use Maatwebsite\Usher\Contracts\Users\Embeddables\Email;
use Maatwebsite\Usher\Contracts\Users\Embeddables\Password;
use Maatwebsite\Usher\Contracts\Users\Embeddables\BannedAt;
use Maatwebsite\Usher\Contracts\Shared\Embeddables\UpdatedAt;
use Maatwebsite\Usher\Contracts\Users\Embeddables\LastLoginAt;
use Maatwebsite\Usher\Contracts\Users\Embeddables\RegisteredAt;
use Maatwebsite\Usher\Contracts\Users\Embeddables\SuspendedTill;
use Maatwebsite\Usher\Contracts\Users\Embeddables\LastAttemptAt;
use Maatwebsite\Usher\Contracts\Users\Embeddables\HashedPassword;
use Maatwebsite\Usher\Domain\Users\Events\UserGotAssignedToRole;
use Maatwebsite\Usher\Domain\Users\Events\UserGotRemovedFromRole;

interface User
{

    /**
     * @return mixed
     */
    public function getId();

    /**
     * @return Name
     */
    public function getName();

    /**
     * @param Name $name
     */
    public function setName(Name $name);

    /**
     * @return Email
     */
    public function getEmail();

    /**
     * @param Email $email
     */
    public function setEmail(Email $email);

    /**
     * @return HashedPassword
     */
    public function getPassword();

    /**
     * @param Password $password
     */
    public function setPassword(Password $password);

    /**
     * @return array
     */
    public function getPermissions();

    /**
     * @param array $permissions
     */
    public function setPermissions(array $permissions = array());

    /**
     * @return LastAttemptAt
     */
    public function getLastAttemptAt();

    /**
     * @param LastAttemptAt $last_attempt_at
     */
    public function setLastAttemptAt(LastAttemptAt $last_attempt_at);

    /**
     * @return LastLoginAt
     */
    public function getLastLoginAt();

    /**
     * @param LastLoginAt $last_login_at
     */
    public function setLastLoginAt(LastLoginAt $last_login_at);

    /**
     * @return SuspendedTill
     */
    public function getSuspendedTill();

    /**
     * @param SuspendedTill $suspended_till
     */
    public function setSuspendedTill(SuspendedTill $suspended_till);

    /**
     * Check if is suspended
     * @return bool
     */
    public function isSuspended();

    /**
     * Suspend for x minutes
     * @param int $minutes
     * @return mixed
     */
    public function suspend($minutes = 15);

    /**
     * @return mixed
     */
    public function unsetSuspended();

    /**
     * @return BannedAt
     */
    public function getBannedAt();

    /**
     * @param BannedAt $banned_at
     */
    public function setBannedAt(BannedAt $banned_at);

    /**
     * Check if is banned
     * @return bool
     */
    public function isBanned();

    /**
     * Ban user
     * @return mixed
     */
    public function ban();

    /**
     * @return RegisteredAt
     */
    public function getRegisteredAt();

    /**
     * @param RegisteredAt $registered_at
     */
    public function setRegisteredAt(RegisteredAt $registered_at);

    /**
     * @return UpdatedAt
     */
    public function getUpdatedAt();

    /**
     * @param UpdatedAt $updated_at
     */
    public function setUpdatedAt(UpdatedAt $updated_at);

    /**
     * @return ArrayCollection|\Maatwebsite\Usher\Contracts\Roles\Role[]
     */
    public function getRoles();

    /**
     * @param ArrayCollection|Role[] $roles
     */
    public function setRoles(ArrayCollection $roles);

    /**
     * @param Role $role
     */
    public function assignRole(Role $role);

    /**
     * Check if user has certain role
     * @param $roleId
     * @return mixed
     */
    public function hasRole($roleId);

    /**
     * @param Role $role
     */
    public function removeRole(Role $role);

    /**
     * Remove all roles
     */
    public function removeAllRoles();
}
