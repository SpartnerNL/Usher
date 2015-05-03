<?php namespace Maatwebsite\Usher\Providers;

use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Maatwebsite\Usher\Contracts\Users\UserRepository;

class UsherUserProvider implements UserProvider
{

    /**
     * @var Hasher
     */
    protected $hasher;

    /**
     * @var UserRepository
     */
    protected $repository;

    /**
     * @var string
     */
    protected $entity;

    /**
     * @param Hasher         $hasher
     * @param UserRepository $repository
     * @param                $entity
     */
    public function __construct(Hasher $hasher, UserRepository $repository, $entity)
    {
        $this->hasher = $hasher;
        $this->entity = $entity;
        $this->repository = $repository;
    }

    /**
     * Retrieve a user by their unique identifier.
     * @param  mixed $identifier
     * @return Authenticatable|null
     */
    public function retrieveById($identifier)
    {
        return $this->repository->findWithRole($identifier);
    }

    /**
     * Retrieve a user by by their unique identifier and "remember me" token.
     * @param  mixed  $identifier
     * @param  string $token
     * @return Authenticatable|null
     */
    public function retrieveByToken($identifier, $token)
    {
        $entity = $this->getEntity();

        return $this->repository->findWithRoleByCriteria([
            $entity->getKeyName()           => $identifier,
            $entity->getRememberTokenName() => $token
        ]);
    }

    /**
     * Update the "remember me" token for the given user in storage.
     * @param  Authenticatable $user
     * @param  string          $token
     * @return void
     */
    public function updateRememberToken(Authenticatable $user, $token)
    {
        $user->setRememberToken($token);
        $this->repository->flush();
    }

    /**
     * Retrieve a user by the given credentials.
     * @param  array $credentials
     * @return Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        return $this->repository->findByCredentials($credentials);
    }

    /**
     * Validate a user against the given credentials.
     * @param  Authenticatable $user
     * @param  array           $credentials
     * @return bool
     */
    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        return $this->hasher->check($credentials['password'], $user->getAuthPassword());
    }

    /**
     * Returns instantiated entity.
     *
     * @return mixed
     */
    protected function getEntity()
    {
        return new $this->entity;
    }
}
