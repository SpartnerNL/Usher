<?php namespace Maatwebsite\Usher\Tests\Domain\Users\Bans;

use Maatwebsite\Usher\Domain\Users\Suspends\SuspendedTill;
use Maatwebsite\Usher\Domain\Users\UsherUser;
use Maatwebsite\Usher\Tests\TestCase;

class SuspendableTraitTest extends TestCase
{

    /**
     * @var UsherUser
     */
    protected $entity;


    public function setUp()
    {
        $this->entity = new UsherUser();
        $this->entity->setSuspendedTill(new SuspendedTill());
        $this->entity->getSuspendedTill()->setDate(null);
    }


    public function test_suspend_a_user()
    {
        $this->assertFalse($this->entity->isSuspended());

        $this->entity->suspend();

        $this->assertTrue($this->entity->isSuspended());
    }


    public function test_get_suspended_at_date()
    {
        $this->assertNull($this->entity->getSuspendedTill()->getDate());

        $this->entity->suspend();

        $this->assertInstanceOf('Maatwebsite\Usher\Contracts\Users\Embeddables\SuspendedTill', $this->entity->getSuspendedTill());
    }


    public function test_unset_a_suspend()
    {
        $this->entity->suspend();
        $this->assertTrue($this->entity->isSuspended());

        $this->entity->unsetSuspended();
        $this->assertFalse($this->entity->isSuspended());
    }
}
