<?php namespace Maatwebsite\Usher\Domain\Users\Suspends;

use Maatwebsite\Usher\Contracts\Users\Embeddables\SuspendedTill as SuspendedTillInterface;
use Maatwebsite\Usher\Domain\Users\Events\UserGotSuspended;

trait Suspendable {

    /**
     * @ORM\Embedded(class = "Maatwebsite\Usher\Domain\Users\Suspends\SuspendedTill", columnPrefix=false)
     * @var SuspendedTillInterface
     */
    protected $suspended_till = null;

    /**
     * @return SuspendedTillInterface
     */
    public function getSuspendedTill()
    {
        return $this->suspended_till;
    }

    /**
     * @param SuspendedTillInterface $suspended_till
     */
    public function setSuspendedTill(SuspendedTillInterface $suspended_till)
    {
        $this->suspended_till = $suspended_till;
    }

    /**
     * Check if is suspended
     * @return bool
     */
    public function isSuspended()
    {
        return !$this->getSuspendedTill()->inPast();
    }

    /**
     * Suspend for x minutes
     * @param int $minutes
     * @return mixed
     */
    public function suspend($minutes = 15)
    {
        $this->setSuspendedTill(
            SuspendedTill::addMinutes($minutes)
        );

        event(new UserGotSuspended($this));
    }

    /**
     * @return mixed
     */
    public function unsetSuspended()
    {
        $this->suspended_till = null;
    }

}
