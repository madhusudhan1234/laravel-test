<?php

class Product extends Eloquent
{
    /**
     * @var string
     */
    protected $table = 'products';

    /**
     * @var array
     */
    protected $fillable = array('image', 'title', 'price', 'description', 'user_id');
}