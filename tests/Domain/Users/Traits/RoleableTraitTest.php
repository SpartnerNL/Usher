<?php namespace Maatwebsite\Usher\Tests\Domain\Users\Traits;

use Maatwebsite\Usher\Tests\TestCase;
use Maatwebsite\Usher\Domain\Users\UsherUser;
use Maatwebsite\Usher\Domain\Roles\UsherRole;

class RoleableTraitTest extends TestCase {

    /**
     * @var UsherUser
     */
    protected $entity;


    public function setUp()
    {
        $this->entity = new UsherUser();
    }


    public function test_can_assign_a_role()
    {
        $role = new UsherRole();
        $role->setName('Admin');
        $this->entity->assignRole($role);

        $this->assertCount(1, $this->entity->getRoles());
    }


    public function test_cannot_assign_same_role_twice()
    {
        $role = new UsherRole();
        $role->setName('Admin');

        $this->entity->assignRole($role);
        $this->entity->assignRole($role);

        $this->assertCount(1, $this->entity->getRoles());
    }


    public function test_can_check_if_has_a_role()
    {
        $role = new UsherRole();

        // Mock id
        $refObject = new \ReflectionObject($role);
        $refProperty = $refObject->getProperty('id');
        $refProperty->setAccessible(true);
        $refProperty->setValue($role, 1);

        $role->setName('Admin');
        $this->entity->assignRole($role);

        $this->assertTrue($this->entity->hasRole(1));
        $this->assertFalse($this->entity->hasRole(2));
    }


    public function test_can_remove_assigned_role()
    {
        $role = new UsherRole();
        $role->setName('Admin');

        $this->entity->assignRole($role);
        $this->assertCount(1, $this->entity->getRoles());

        $this->entity->removeRole($role);
        $this->assertCount(0, $this->entity->getRoles());
    }


    public function test_can_remove_all_roles()
    {
        $role = new UsherRole();
        $role->setName('Admin');

        $this->entity->assignRole($role);
        $this->assertCount(1, $this->entity->getRoles());

        $this->entity->removeAllRoles();
        $this->assertCount(0, $this->entity->getRoles());
    }

}
