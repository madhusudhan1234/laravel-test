<?php namespace repository;

use Illuminate\Database\Eloquent\Collection;
use Cart;

/**
 * Class CartRepository
 * @package repository
 */
class CartRepository
{
    /**
     * @var Cart
     */
    private $carts;

    /**
     * CartRepository constructor.
     * @param Cart $carts
     */
    public function __construct(Cart $carts)
    {
        $this->carts = $carts;
    }

    /**
     * Return all the collection of Carts table
     *
     * @return Collection
     */
    public function all()
    {
        return $this->carts->all();
    }

    /**
     * Return the Particular Cart Object By gettting from it's id
     *
     * @param $id
     * @return Object
     */
    public function find($id)
    {
        return $this->carts->find($id);
    }
    /**
     * Store The Records In Database
     *
     * @param $data
     * @return Object
     */
    public function save($request)
    {
        return $request->save();
    }

    /**
     * Delete the Cart
     * 
     * @param $cart
     * @return Object
     */
    public function delete($cart)
    {
        return $cart->delete();
    }
}