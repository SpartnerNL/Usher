# Usher
### A Doctrine ACL package for Laravel 5

* Login with Doctrine User entity
* User roles
* User banning
* User suspending
* User permissions
* User last login and last attempt event listeners
* Role permissions

## Installation

Include the service provider in `config/app.php`
```php
'Mitch\LaravelDoctrine\LaravelDoctrineServiceProvider',
'Maatwebsite\Usher\UsherServiceProvider'
```

## Config

To change the defaults of this package, publish the config:
```php
php artisan vendor:publish --provider="Maatwebsite\Usher\UsherServiceProvider"
```

## Default usage

Out of the box, you can use the ACL system without defining your own entities. However this is not recommended!

## Custom usage

For example if you want a `Customer` and `Group` entity, you just have to make sure it implements `Maatwebsite\Usher\Contracts\Users\User`. If you want a faster solution, you can optionally extend the MappedSuperclass `Maatwebsite\Usher\Domain\Users\User`. 
*Note that you will have to define the roles relation yourself.

Example with the MappedSuperclass:

```php

use Doctrine\ORM\Mapping as ORM;
use Maatwebsite\Usher\Domain\Users\User;
use Maatwebsite\Usher\Contracts\Users\User as UserInterface;

/**
 * @ORM\Entity(repositoryClass="DoctrineCustomerRepository")
 * @ORM\Table(name="customers")
 * @ORM\HasLifecycleCallbacks()
 */
class Customer extends User implements UserInterface
{
    /**
     * @ORM\ManyToMany(targetEntity="Group", inversedBy="customers")
     * @ORM\JoinTable(name="customer_groups")
     * @var ArrayCollection|\App\Domain\Customers\Entities\Role[]
     */
    protected $groups;
    
    /**
     * Customer Constructor
     */
    public function __construct()
    {
        $this->groups = new ArrayCollection();
    }
    
    /**
     * @return ArrayCollection|\Maatwebsite\Usher\Contracts\Roles\Role[]
     */
    public function getRoles()
    {
        return $this->groups;
    }
  }
```

Same as with the `User` MappedSuperclass, you'll have to define the User relation yourself.

```php
/**
 * @ORM\Entity(repositoryClass="DoctrineRoleRepository")
 * @ORM\Table(name="groups")
 * @ORM\HasLifecycleCallbacks()
 */
class Group extends Role implements RoleInterface
{

    /**
     * @ORM\ManyToMany(targetEntity="Customer", mappedBy="groups")
     * @var ArrayCollection|Customer[]
     **/
    protected $customers;

    /**
     * Role Constructor
     */
    public function __construct()
    {
        $this->customers = new ArrayCollection();
    }

    /**
     * @return ArrayCollection|\Maatwebsite\Usher\Contracts\Users\User[]
     */
    public function getUsers()
    {
        return $this->customers;
    }
}
```

Next you'll have to update the class reference in `config/usher.php` for the `user.entity` en `role.entity`

```php
return [
    'users'  => [
        'entity' => 'Customer'
    ],
    'roles'  => [
        'entity' => 'Group'
    ]
]
```
