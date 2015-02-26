<?php namespace Maatwebsite\Usher\Domain\Shared\Embeddables;

use Doctrine\ORM\Mapping as ORM;
use Maatwebsite\Usher\Contracts\Shared\Embeddables\UpdatedAt as UpdatedAtInterface;

/**
 * @ORM\Embeddable
 */
class UpdatedAt extends Date implements UpdatedAtInterface
{

    /**
     * @ORM\Column(type="datetime", nullable=true, name="updated_at")
     */
    protected $date;

}
