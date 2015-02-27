<?php namespace Maatwebsite\Usher\Domain\Users\Activations;

use Doctrine\ORM\Mapping as ORM;
use Maatwebsite\Usher\Domain\Shared\Embeddables\Date;
use Maatwebsite\Usher\Contracts\Users\Activiations\ActivatedAt as ActivatedAtInterface;

/**
 * @ORM\Embeddable
 */
class ActivatedAt extends Date implements ActivatedAtInterface
{

    /**
     * @ORM\Column(type="datetime", nullable=true, name="activated_at")
     */
    protected $date;

}
