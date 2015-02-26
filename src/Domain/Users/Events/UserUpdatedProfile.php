<?php namespace Maatwebsite\Usher\Domain\Users\Events;

use Maatwebsite\Usher\Contracts\Users\User;

class UserUpdatedProfile
{

    /**
     * @var User
     */
    public $user;

    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
}
