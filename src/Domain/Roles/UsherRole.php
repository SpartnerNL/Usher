<?php namespace Maatwebsite\Usher\Domain\Roles;

use Maatwebsite\Usher\Contracts\Roles\Role as RoleInterface;

/**
 * @ORM\Entity(repositoryClass="Maatwebsite\Usher\Infrastructure\Roles\DoctrineRoleRepository")
 * @ORM\Table(name="roles")
 * @ORM\HasLifecycleCallbacks()
 */
class UsherRole extends Role implements RoleInterface
{

}
