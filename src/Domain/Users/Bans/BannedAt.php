<?php namespace Maatwebsite\Usher\Domain\Users\Bans;

use Doctrine\ORM\Mapping as ORM;
use Maatwebsite\Usher\Domain\Shared\Embeddables\Date;
use Maatwebsite\Usher\Contracts\Users\Embeddables\BannedAt as BannedAtInterface;

/**
 * @ORM\Embeddable
 */
class BannedAt extends Date implements BannedAtInterface
{

    /**
     * @ORM\Column(type="datetime", nullable=true, name="banned_at")
     */
    protected $date;

}
