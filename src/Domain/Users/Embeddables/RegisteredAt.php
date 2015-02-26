<?php namespace Maatwebsite\Usher\Domain\Users\Embeddables;

use Doctrine\ORM\Mapping as ORM;
use Maatwebsite\Usher\Contracts\Users\Embeddables\RegisteredAt as RegisteredAtInterface;
use Maatwebsite\Usher\Domain\Shared\Embeddables\Date;

/**
 * @ORM\Embeddable
 */
class RegisteredAt extends Date implements RegisteredAtInterface
{

    /**
     * @ORM\Column(type="datetime", nullable=true, name="registered_at")
     */
    protected $date;

}
