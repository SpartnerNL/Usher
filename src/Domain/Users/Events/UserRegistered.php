<?php namespace Maatwebsite\Usher\Domain\Users\Events;

use Maatwebsite\Usher\Contracts\Users\User;

class UserRegistered
{

    /**
     * @var User
     */
    public $user;

    /**
     * @var string|null
     */
    public $password;

    /**
     * @param User        $user
     * @param string|null $password
     */
    public function __construct(User $user, $password = null)
    {
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return null|string
     */
    public function getPassword()
    {
        return $this->password;
    }
}
