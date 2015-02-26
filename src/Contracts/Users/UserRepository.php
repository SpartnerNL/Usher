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
     * Create a user resource
     * @param  array $data
     * @return User
     */
    public function create(array $data);

    /**
     * Create a user and assign roles to it
     * @param  array $data
     * @param  array $roles
     * @return void
     */
    public function createWithRoles($data, $roles);

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
     * Update a user
     * @param User $user
     * @param $data
     * @return User
     */
    public function update(User $user, array $data);

    /**
     * Update a user and sync its roles
     * @param  int $userId
     * @param      $data
     * @param      $roles
     * @return mixed
     */
    public function updateAndSyncRoles($userId, $data, $roles);

    /**
     * Deletes a user
     * @param $id
     * @return mixed
     */
    public function delete($id);

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
