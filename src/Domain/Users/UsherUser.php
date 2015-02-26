<?php namespace Maatwebsite\Usher\Domain\Users;

use Maatwebsite\Usher\Contracts\Users\User as UserInterface;

/**
 * @ORM\Entity(repositoryClass="Maatwebsite\Usher\Infrastructure\Users\DoctrineUserRepository")
 * @ORM\Table(name="users")
 * @ORM\HasLifecycleCallbacks()
 */
class UsherUser extends User implements UserInterface
{

}
