<?php namespace Maatwebsite\Usher\Tests\Domain\Users\Activations;

use Maatwebsite\Usher\Domain\Users\Activations\ActivationCode;
use Maatwebsite\Usher\Domain\Users\UsherUser;
use Maatwebsite\Usher\Tests\TestCase;

class ActivatableTest extends TestCase {

    /**
     * @var UsherUser
     */
    protected $entity;


    public function setUp()
    {
        $this->entity = new UsherUser();
        $this->entity->setActivationCode(new ActivationCode(
            'code'
        ));
    }


    public function test_can_get_activation_code()
    {
        $this->assertEquals('code', $this->entity->getActivationCode()->getCode());
    }


    public function test_can_activate_account()
    {
        $this->assertNull($this->entity->getActivatedAt());

        $this->entity->activate(new ActivationCode(
            'code'
        ));

        $this->assertInstanceOf('Maatwebsite\Usher\Contracts\Users\Activiations\ActivatedAt', $this->entity->getActivatedAt());
    }


    public function test_can_force_activation()
    {
        $this->assertNull($this->entity->getActivatedAt());

        $this->entity->activate(null, true);

        $this->assertInstanceOf('Maatwebsite\Usher\Contracts\Users\Activiations\ActivatedAt', $this->entity->getActivatedAt());
    }


    public function test_can_check_if_is_activated()
    {
        $this->assertFalse($this->entity->isActivated());

        $this->entity->activate(null, true);

        $this->assertTrue($this->entity->isActivated());
    }


    public function test_cannot_activate_with_invalid_code()
    {
        $this->setExpectedException('Maatwebsite\Usher\Exceptions\InvalidActiviationCodeException');

        $this->entity->activate(new ActivationCode(
            'wrong'
        ));
    }

}
