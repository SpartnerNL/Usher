<?php namespace Maatwebsite\Usher\Domain\Users\Suspends;

use Carbon\Carbon;
use Doctrine\ORM\Mapping as ORM;
use Maatwebsite\Usher\Contracts\Users\Embeddables\SuspendedTill as SuspendedTillInterface;
use Maatwebsite\Usher\Domain\Shared\Embeddables\Date;

/**
 * @ORM\Embeddable
 */
class SuspendedTill extends Date implements SuspendedTillInterface
{

    /**
     * @ORM\Column(type="datetime", nullable=true, name="suspended_till")
     */
    protected $date;

    /**
     * Suspend for x minutes
     * @param $minutes
     * @return static
     */
    public static function addMinutes($minutes)
    {
        return new static(
            Carbon::now()->addMinutes($minutes)
        );
    }
}
