<?php namespace Maatwebsite\Usher\Contracts\Users;

use Maatwebsite\Usher\Contracts\Users\Embeddables\Email;

interface UserRepository
{

    /**
     * Returns all the users
     * @return object
     */
    public function all();

    /**
     * Find a user by its ID
     * @param $id
     * @return User
     */
    public function find($id);

    /**
     * Find user by email
     * @param Email $email
     * @return User
     */
    public function findByEmail(Email $email);

    /**
     * Deletes a user
     * @param User $user
     */
    public function delete(User $user);

    /**
     * Persist entity
     * @param $entity
     * @return mixed
     */
    public function persist($entity);

    /**
     * Flush entity manager
     * @return mixed
     */
    public function flush();

    /**
     * Find a user by its credentials
     * @param  array $credentials
     * @return mixed
     */
    public function findByCredentials(array $credentials);
}
