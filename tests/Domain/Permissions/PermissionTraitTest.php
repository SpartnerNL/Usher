<?php namespace Maatwebsite\Usher\Tests\Domain\Permissions;

use Maatwebsite\Usher\Domain\Roles\UsherRole;
use Maatwebsite\Usher\Domain\Users\UsherUser;
use Maatwebsite\Usher\Tests\TestCase;

class PermissionTraitTest extends TestCase
{

    /**
     * @var UsherUser
     */
    protected $entity;


    public function setUp()
    {
        $this->entity = new UsherUser();
        $this->entity->setPermissions([
            'index'  => true,
            'show'   => false,
            'create' => true,
            'edit'   => false,
        ]);

        $this->role = new UsherRole();
        $this->role->setPermissions([
            'index'   => true,
            'show'    => false,
            'create'  => false,
            'edit'    => true,
            'destroy' => true
        ]);

        $this->entity->assignRole($this->role);
    }


    public function test_simple_root_level_user_permission()
    {
        $this->assertTrue($this->entity->hasAccess('index'));
        $this->assertFalse($this->entity->hasAccess('show'));
        $this->assertTrue($this->entity->hasAccess('create'));
        $this->assertFalse($this->entity->hasAccess('edit'));
    }


    public function test_user_permission_should_overrule_role_permission()
    {
        $this->assertTrue($this->entity->hasAccess('create'));
        $this->assertFalse($this->role->hasAccess('create'));
    }


    public function test_use_role_permission_when_user_permission_does_not_exst()
    {
        $this->assertTrue($this->entity->hasAccess('destroy'));
        $this->assertTrue($this->role->hasAccess('destroy'));
    }


    public function test_deny_access_when_permission_does_not_exist()
    {
        $this->assertFalse($this->entity->hasAccess('non-existing'));
        $this->assertFalse($this->role->hasAccess('non-existing'));
    }
}
