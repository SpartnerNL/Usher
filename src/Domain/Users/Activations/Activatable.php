<?php namespace Maatwebsite\Usher\Domain\Users\Activations;

use Maatwebsite\Usher\Domain\Users\Events\UserGotActivated;
use Maatwebsite\Usher\Domain\Users\Events\UserGotDeactivated;
use Maatwebsite\Usher\Exceptions\InvalidActiviationCodeException;

trait Activatable
{

    /**
     * @ORM\Embedded(class = "Maatwebsite\Usher\Domain\Users\Activations\ActivatedAt", columnPrefix=false)
     * @var ActivatedAt
     */
    protected $activated_at = null;

    /**
     * @ORM\Embedded(class = "Maatwebsite\Usher\Domain\Users\Activations\ActivationCode", columnPrefix=false)
     * @var ActivationCode
     */
    protected $activation_code;

    /**
     * Ban user
     * @param ActivationCode $code
     * @param bool           $force
     * @return mixed
     */
    public function activate(ActivationCode $code = null, $force = false)
    {
        if (!$this->isActivated() && ($force || $this->checkIfActivationCodeMatches($code))) {
            $this->setActivatedAt(
                new ActivatedAt()
            );

            event(new UserGotActivated($this));
        }
    }

    /**
     * @return bool
     */
    public function isActivated()
    {
        return $this->getActivatedAt() && !is_null($this->getActivatedAt()->getDate())
            ? true
            : false;
    }

    /**
     * Ban user
     * @return mixed
     */
    public function deactivate()
    {
        $this->activated_at = null;

        event(new UserGotDeactivated($this));
    }

    /**
     * @return ActivatedAt
     */
    public function getActivatedAt()
    {
        return $this->activated_at;
    }

    /**
     * @param ActivatedAt $activated_at
     */
    public function setActivatedAt(ActivatedAt $activated_at = null)
    {
        $this->activated_at = $activated_at;
    }

    /**
     * @return ActivationCode
     */
    public function getActivationCode()
    {
        return $this->activation_code;
    }

    /**
     * @param ActivationCode $activation_code
     */
    public function setActivationCode(ActivationCode $activation_code)
    {
        $this->activation_code = $activation_code;
    }

    /**
     * @param ActivationCode $code
     * @return mixed
     */
    protected function checkIfActivationCodeMatches(ActivationCode $code)
    {
        if ($this->getActivationCode()->equals($code)) {
            return true;
        }

        throw new InvalidActiviationCodeException();
    }
}
