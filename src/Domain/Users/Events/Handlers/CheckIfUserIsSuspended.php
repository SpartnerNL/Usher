<?php namespace Maatwebsite\Usher\Domain\Users\Events\Handlers;

use Maatwebsite\Usher\Contracts\Users\UserRepository;
use Maatwebsite\Usher\Domain\Users\Embeddables\Email;
use Maatwebsite\Usher\Exceptions\UserIsSuspendedException;

class CheckIfUserIsSuspended
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
     * @throws UserIsSuspendedException
     */
    public function handle($event)
    {
        $user = $this->repository->findByEmail(new Email(
            $event['email']
        ));

        if ($user && $user->isSuspended()) {
            throw new UserIsSuspendedException('You are temporarily suspended. Try again later.');
        } elseif ($user && $user->getSuspendedTill()) {
            $user->unsetSuspended();
            $this->repository->persist($user);
            $this->repository->flush();
        }
    }
}
