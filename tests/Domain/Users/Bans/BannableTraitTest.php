<?php namespace Maatwebsite\Usher\Tests\Domain\Users\Bans;

use Maatwebsite\Usher\Domain\Roles\UsherRole;
use Maatwebsite\Usher\Domain\Users\UsherUser;
use Maatwebsite\Usher\Tests\TestCase;

class BannableTraitTest extends TestCase
{

    /**
     * @var UsherUser
     */
    protected $entity;


    public function setUp()
    {
        $this->entity = new UsherUser();
    }


    public function test_ban_a_user()
    {
        $this->assertFalse($this->entity->isBanned());

        $this->entity->ban();

        $this->assertTrue($this->entity->isBanned());
    }


    public function test_get_banned_at_date()
    {
        $this->assertNull($this->entity->getBannedAt());

        $this->entity->ban();

        $this->assertInstanceOf('Maatwebsite\Usher\Contracts\Users\Embeddables\BannedAt', $this->entity->getBannedAt());
    }


    public function test_unset_a_ban()
    {
        $this->entity->ban();
        $this->assertTrue($this->entity->isBanned());

        $this->entity->unsetBan();
        $this->assertFalse($this->entity->isBanned());
    }
}
