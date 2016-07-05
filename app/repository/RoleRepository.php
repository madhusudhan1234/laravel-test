<?php namespace repository;


use Role;

class RoleRepository
{
    /**
     * @var Role
     */
    private $roles;

    /**
     * RoleRepository constructor.
     * @param Role $roles
     */
    public function __construct(Role $roles)
    {
        $this->roles = $roles;
    }

    /**
     * Return all role Collection
     * 
     * @return mixed
     */
    public function all()
    {
        return $this->roles->all();
    }

    /**
     * Get list of the all the users
     *
     * @return array
     */
    public function lists()
    {
        return $this->users->lists('role_name','id');
    }

    /**
     * Return The Particular Role From id
     * 
     * @param $id
     * @return Object
     */
    public function find($id)
    {
        return $this->roles->find($id);
    }
    /**
     * Store/Save new Role information in the storage
     *
     * @param $data
     * @return Object
     */
    public function save($input)
    {
        return $this->roles->create($input);

    }

    /**
     * Edit/Update new Role information
     *
     * @param $input
     * @param $user
     * @return Object
     */
    public function update($input, $role)
    {
        return $role->update($input);
    }

    /**
     * Delete The Role From Database
     *
     * @param $user
     * @return Object
     */
    public function delete($role)
    {
        return $role->delete();
    }

}