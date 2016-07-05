<?php

class Cart extends Eloquent{

    /**
     * Name of the Table Which is carts
     *
     * @var string
     */
    protected $table = 'carts';

    /**
     * Fillable Fields Using Html Form
     *
     * @var array
     */
    protected $fillable = array('product_id','price','quantity','status');
}