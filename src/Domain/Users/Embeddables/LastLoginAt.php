<?php namespace Maatwebsite\Usher\Domain\Users\Embeddables;

use Doctrine\ORM\Mapping as ORM;
use Maatwebsite\Usher\Contracts\Users\Embeddables\LastLoginAt as LastLoginAtInterface;
use Maatwebsite\Usher\Domain\Shared\Embeddables\Date;

/**
 * @ORM\Embeddable
 */
class LastLoginAt extends Date implements LastLoginAtInterface
{

    /**
     * @ORM\Column(type="datetime", nullable=true, name="last_login_at")
     */
    protected $date;

}
