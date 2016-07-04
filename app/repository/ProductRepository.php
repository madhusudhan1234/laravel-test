<?php namespace repository;

use Product;
use User;

class ProductRepository
{
    /**
     * @var Product
     */
    private $products;
    

    /**
     * ProductRepository constructor.
     * @param Product $products
     * @param User $users
     */
    public function __construct(Product $products)
    {
        $this->products = $products;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->products->all();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->products->find($id);
    }
}