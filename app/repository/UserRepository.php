<?php namespace repository;

use User;

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
     * @return mixed
     */
    public function all()
    {
        return $this->users->all();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->users->find($id);
    }



    /**
     * @return mixed
     */
    public function lists()
    {
        return $this->users->lists('first_name','id');
    }
}