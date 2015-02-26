<?php namespace Maatwebsite\Usher\Domain\Shared\Embeddables;

use Doctrine\ORM\Mapping as ORM;
use Maatwebsite\Usher\Contracts\Shared\Embeddables\CreatedAt as CreatedAtInterface;

/**
 * @ORM\Embeddable
 */
class CreatedAt extends Date implements CreatedAtInterface
{

    /**
     * @ORM\Column(type="datetime", nullable=true, name="created_at")
     */
    protected $date;

}
