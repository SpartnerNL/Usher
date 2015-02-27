<?php namespace Maatwebsite\Usher\Tests\Domain\Users\Traits;

use Carbon\Carbon;
use Maatwebsite\Usher\Domain\Shared\Embeddables\UpdatedAt;
use Maatwebsite\Usher\Domain\Users\Embeddables\LastAttemptAt;
use Maatwebsite\Usher\Domain\Users\Embeddables\LastLoginAt;
use Maatwebsite\Usher\Domain\Users\Embeddables\RegisteredAt;
use Maatwebsite\Usher\Tests\TestCase;
use Maatwebsite\Usher\Domain\Users\UsherUser;
use Maatwebsite\Usher\Domain\Roles\UsherRole;

class TimestampsTraitTest extends TestCase {

    /**
     * @var UsherUser
     */
    protected $entity;


    public function setUp()
    {
        $this->entity = new UsherUser();
    }


    public function test_can_set_last_attempt()
    {
        $date = Carbon::now();

        $this->entity->setLastAttemptAt(new LastAttemptAt(
            $date
        ));

        $this->assertEquals($date, $this->entity->getLastAttemptAt()->getDate());
    }


    public function test_can_set_last_login()
    {
        $date = Carbon::now();

        $this->entity->setLastLoginAt(new LastLoginAt(
            $date
        ));

        $this->assertEquals($date, $this->entity->getLastLoginAt()->getDate());
    }


    public function test_can_set_registered_at()
    {
        $date = Carbon::now();

        $this->entity->setRegisteredAt(new RegisteredAt(
            $date
        ));

        $this->assertEquals($date, $this->entity->getRegisteredAt()->getDate());
    }


    public function test_can_set_updated_at()
    {
        $date = Carbon::now();

        $this->entity->setUpdatedAt(new UpdatedAt(
            $date
        ));

        $this->assertEquals($date, $this->entity->getUpdatedAt()->getDate());
    }

}
