<?php namespace Maatwebsite\Usher\Domain\Shared\Embeddables;

use Carbon\Carbon;
use Maatwebsite\Usher\Domain\Shared\Embedabble;
use Maatwebsite\Usher\Contracts\Shared\Embeddables\Date as DateInterface;

class Date extends Embedabble implements DateInterface
{

    /**
     * @var Carbon
     */
    protected $date;

    /**
     * @param Carbon $date
     */
    public function __construct(Carbon $date = null)
    {
        $this->setDate(
            $date ?: Carbon::now()
        );
    }

    /**
     * @param string $format
     * @return null|string
     */
    public function format($format = 'd-m-Y H:i:s')
    {
        if ($date = $this->getDate()) {
            return (string) $date->format($format);
        }

        return '-';
    }

    /**
     * Check if date is in past
     * @return mixed
     */
    public function inPast()
    {
        if ($this->date) {
            return $this->getDate()->isPast();
        }

        return true;
    }

    /**
     * @return Carbon
     */
    public function getDate()
    {
        if ($this->date) {
            return Carbon::instance($this->date);
        }

        return null;
    }

    /**
     * @param Carbon $date
     */
    public function setDate(Carbon $date = null)
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function toString()
    {
        if ($date = $this->getDate()) {
            return (string) $date->format('d-m-Y H:i:s');
        }

        return '-';
    }
}
