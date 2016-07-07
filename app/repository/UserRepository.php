<?php namespace repository;

use Illuminate\Database\Eloquent\Collection;
use User;

/**
 * Handle all the database operation for user model/users table
 *
 * Class UserRepository
 * @package repository
 */
class UserRepository
{
    /**
     * @var User
     */
    private $users;

    /**
     * UserRepository constructor.
     * @param User $users
     */
    public function __construct(User $users)
    {
        $this->users = $users;
    }

    /**
     * Get all the users
     *
     * @return Collection
     */
    public function all()
    {
        return $this->users->all();
    }

    /**
     * Find the specified user by given id
     *
     * @param $id
     * @return Object
     */
    public function find($id)
    {
        return $this->users->find($id);
    }


    /**
     * Get list of the all the users
     *
     * @return array
     */
    public function lists()
    {
        return $this->users->lists('first_name', 'id');
    }

    /**
     * Store/Save new user information in the storage
     *
     * @param $data
     * @return Object
     */
    public function save($data)
    {
        return $this->users->create($data);

    }

    /**
     * Edit/Update new User information
     *
     * @param $input
     * @param $user
     * @return Object
     */
    public function update($input, $user)
    {
        return $user->update($input);
    }

    /**
     * Delete The User From Database
     *
     * @param $user
     * @return Object
     */
    public function delete($user)
    {
        return $user->delete();
    }

}