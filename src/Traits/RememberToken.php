<?php namespace Maatwebsite\Usher\Traits;

use Doctrine\ORM\Mapping as ORM;

trait RememberToken
{

    /**
     * @ORM\Column(name="remember_token", type="string", nullable=true)
     */
    private $remember_token;

    /**
     * Get the token value for the "remember me" session.
     * @return string
     */
    public function getRememberToken()
    {
        return $this->remember_token;
    }

    /**
     * Set the token value for the "remember me" session.
     * @param  string $value
     */
    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    /**
     * Get the column name for the "remember me" token.
     * @return string
     */
    public function getRememberTokenName()
    {
        return 'remember_token';
    }
}
