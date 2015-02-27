<?php namespace Maatwebsite\Usher\tESTS\Domain\Users;

use Illuminate\Contracts\Hashing\Hasher;
use Maatwebsite\Usher\Domain\Users\Embeddables\Email;
use Maatwebsite\Usher\Domain\Users\Embeddables\Name;
use Maatwebsite\Usher\Domain\Users\Embeddables\Password;
use Maatwebsite\Usher\Domain\Users\UsherUser;
use Maatwebsite\Usher\Tests\TestCase;

class UserTest extends TestCase
{

    /**
     * @var UsherUser
     */
    protected $entity;


    public function setUp()
    {
        $this->entity = new UsherUser();
    }


    public function test_can_set_name()
    {
        $this->entity->setName(new Name(
            'Patrick',
            'Brouwers'
        ));

        $this->assertInstanceOf('Maatwebsite\Usher\Domain\Users\Embeddables\Name', $this->entity->getName());
        $this->assertEquals('Patrick Brouwers', (string) $this->entity->getName());
    }


    public function test_can_set_email()
    {
        $this->entity->setEmail(new Email(
            'patrick@maatwebsite.nl'
        ));

        $this->assertInstanceOf('Maatwebsite\Usher\Domain\Users\Embeddables\Email', $this->entity->getEmail());
        $this->assertEquals('patrick@maatwebsite.nl', (string) $this->entity->getEmail());
    }


    public function test_can_set_password()
    {
        $this->entity->setPassword(new Password(
            'passwordsdfdfsfs',
            new HasherStub()
        ));

        $this->assertInstanceOf('Maatwebsite\Usher\Domain\Users\Embeddables\Password', $this->entity->getPassword());
        $this->assertEquals('hashed', (string) $this->entity->getPassword());
    }


    public function test_can_check_if_has_access()
    {
        $this->entity->setPermissions([
            'dashboard.index' => true,
            'dashboard.show'  => false
        ]);

        $this->assertTrue($this->entity->hasAccess('dashboard.index'));
        $this->assertFalse($this->entity->hasAccess('dashboard.show'));
    }
}


class HasherStub implements Hasher
{

    public function make($value, array $options = array())
    {
        return 'hashed';
    }

    public function check($value, $hashedValue, array $options = array())
    {
    }

    public function needsRehash($hashedValue, array $options = array())
    {
    }
}
