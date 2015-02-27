<?php namespace Maatwebsite\Usher\Domain\Users\Events\Handlers;

use Illuminate\Contracts\Auth\Guard;
use Maatwebsite\Usher\Contracts\Users\User;
use Maatwebsite\Usher\Contracts\Users\UserRepository;
use Maatwebsite\Usher\Exceptions\UserIsSuspendedException;

class CheckIfUserIsSuspended
{

    /**
     * @var Guard
     */
    private $guard;

    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * @param Guard          $guard
     * @param UserRepository $repository
     * @internal param UserRepository $repository
     */
    public function __construct(Guard $guard, UserRepository $repository)
    {
        $this->guard = $guard;
        $this->repository = $repository;
    }

    /**
     * Handle
     * @param User $user
     */
    public function handle(User $user)
    {
        if ($user && $user->isSuspended()) {
            $this->guard->logout();
            throw new UserIsSuspendedException('You are temporarily suspended. Try again later.');
        } elseif ($user && $user->getSuspendedTill()) {
            $user->unsetSuspended();
            $this->repository->persist($user);
            $this->repository->flush();
        }
    }
}
