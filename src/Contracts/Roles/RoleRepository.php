<?php namespace Maatwebsite\Usher\Contracts\Roles;

interface RoleRepository
{

    /**
     * Returns all the users
     * @return object
     */
    public function all();

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
     * Deletes a role
     * @param Role $role
     */
    public function delete(Role $role);
}
