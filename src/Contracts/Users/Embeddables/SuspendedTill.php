<?php namespace Maatwebsite\Usher\Contracts\Users\Embeddables;

use Maatwebsite\Usher\Contracts\Shared\Embeddables\Date;

interface SuspendedTill extends Date
{

    /**
     * Suspend for x minutes
     * @param $minutes
     */
    public static function addMinutes($minutes);
}
