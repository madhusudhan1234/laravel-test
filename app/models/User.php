<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Support\Facades\Hash;

class User extends Eloquent implements UserInterface, RemindableInterface
{

    use UserTrait, RemindableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array('password', 'remember_token');

    /**
     * The Attributes which are allow to fill from Html Form
     *
     * @var array
     */
    protected $fillable = array('first_name', 'last_name', 'email', 'password');


    /**
     * Hash user password
     *
     * @param $password
     * @return String
     */
    public function setPasswordAttribute($password)
    {
        return $this->attributes['password'] = Hash::make($password);
    }

}
