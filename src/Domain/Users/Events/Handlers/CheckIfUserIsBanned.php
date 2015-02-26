<?php namespace Maatwebsite\Usher\Domain\Users\Events\Handlers;

use Maatwebsite\Usher\Domain\Users\Embeddables\Email;
use Maatwebsite\Usher\Contracts\Users\UserRepository;
use Maatwebsite\Usher\Exceptions\UserIsBannedException;

class CheckIfUserIsBanned
{

    /**
     * @var UserRepository
     */
    protected $repository;

    /**
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Handle
     * @param Event $event
     * @throws UserIsBannedException
     */
    public function handle($event)
    {
        $user = $this->repository->findByEmail(new Email(
            $event['email']
        ));

        if ($user && $user->isBanned()) {
            throw new UserIsBannedException('You are banned from the system');
        }
    }
}
