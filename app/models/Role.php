<?php

/**
 * Class Role
 */
class Role extends Eloquent
{
    /**
     * @var string
     */
    protected $table = 'roles';

    /**
     * @var array
     */
    protected $fillable = array('role_name');
}