<?php namespace Maatwebsite\Usher\Contracts\Shared\Embeddables;

use Carbon\Carbon;

interface Date
{

    /**
     * @param string $format
     * @return null|string
     */
    public function format($format = 'd-m-Y H:i:s');

    /**
     * @return Carbon
     */
    public function getDate();

    /**
     * @param Carbon $date
     */
    public function setDate(Carbon $date);

    /**
     * Check if date is in past
     * @return mixed
     */
    public function inPast();
}
