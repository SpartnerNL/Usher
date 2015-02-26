<?php namespace Maatwebsite\Usher\Domain\Users\Embeddables;

use Doctrine\ORM\Mapping as ORM;
use Maatwebsite\Usher\Contracts\Users\Embeddables\LastAttemptAt as LastAttemptAtInterface;
use Maatwebsite\Usher\Domain\Shared\Embeddables\Date;

/**
 * @ORM\Embeddable
 */
class LastAttemptAt extends Date implements LastAttemptAtInterface
{

    /**
     * @ORM\Column(type="datetime", nullable=true, name="last_attempt_at")
     */
    protected $date;

}
