<?php namespace Maatwebsite\Usher\Contracts\Roles;

interface RoleRepository
{

    /**
     * Returns all the users
     * @return object
     */
    public function all();

    /**
     * Create a user resource
     * @param  array $data
     * @return Role
     */
    public function create(array $data);

    /**
     * Find a user by its ID
     * @param $id
     * @return Role
     */
    public function find($id);

    /**
     * Find a role by its name
     * @param  string $name
     * @return mixed
     */
    public function findByName($name);

    /**
     * Update a user
     * @param Role $user
     * @param      $data
     * @return Role
     */
    public function update(Role $user, array $data);

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
}
