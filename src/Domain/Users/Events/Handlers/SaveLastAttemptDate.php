<?php namespace Maatwebsite\Usher\Domain\Users\Events\Handlers;

use Maatwebsite\Usher\Domain\Users\Embeddables\Email;
use Maatwebsite\Usher\Contracts\Users\UserRepository;
use Maatwebsite\Usher\Domain\Users\Embeddables\LastAttemptAt;

class SaveLastAttemptDate
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
     */
    public function handle($event)
    {
        $user = $this->repository->findByEmail(new Email(
            $event['email']
        ));

        if ($user) {

            // Set last attempt timestamp
            $user->setLastAttemptAt(
                new LastAttemptAt
            );

            $this->repository->persist($user);
            $this->repository->flush();
        }
    }
}
