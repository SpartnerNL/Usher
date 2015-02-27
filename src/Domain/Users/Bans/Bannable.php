<?php namespace Maatwebsite\Usher\Domain\Users\Bans;

use Maatwebsite\Usher\Contracts\Users\Embeddables\BannedAt as BannedAtInterface;
use Maatwebsite\Usher\Domain\Users\Events\UserGotBanned;

trait Bannable
{

    /**
     * @ORM\Embedded(class = "Maatwebsite\Usher\Domain\Users\Bans\BannedAt", columnPrefix=false)
     * @var BannedAtInterface
     */
    protected $banned_at = null;

    /**
     * @return BannedAtInterface
     */
    public function getBannedAt()
    {
        return $this->banned_at;
    }

    /**
     * @param BannedAtInterface $banned_at
     */
    public function setBannedAt(BannedAtInterface $banned_at)
    {
        $this->banned_at = $banned_at;
    }

    /**
     * Check if is banned
     * @return bool
     */
    public function isBanned()
    {
        return $this->getBannedAt() && !is_null($this->getBannedAt()->getDate())
            ? true
            : false;
    }

    /**
     * Ban user
     * @return mixed
     */
    public function ban()
    {
        $this->setBannedAt(
            new BannedAt
        );

        event(new UserGotBanned($this));
    }

    /**
     * @return void
     */
    public function unsetBan()
    {
        $this->banned_at = null;
    }
}
