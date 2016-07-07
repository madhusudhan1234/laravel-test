<?php namespace repository;

use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Product;
use User;

/**
 * Class ProductRepository
 * @package repository
 */
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


    /**
     * The method for Update and Save of Product
     *
     * @param $request
     * @return Object
     */
    public function save($request)
    {
        $input = $request->all();

        $input['user_id'] = Auth::user()->id;

        $input = $this->imageUpload($request, $input);

        return $this->products->create($input);
    }

    /**
     * Update Database Record
     *
     * @param $request
     * @param $product
     */
    public function update($request, $product)
    {
        $input = $request->all();

        $input['user_id'] = Auth::user()->id;

        $input = $this->imageUpload($request, $input);

        return $product->update($input);
    }

    /**
     * Method for Delete the Product Item
     *
     * @param $product
     * @return Object
     */
    public function delete($product)
    {
        return $product->delete();
    }

    /**
     * List of all Products for Dropdown list
     *
     * @return array
     */
    public function lists()
    {
        return $this->products->lists('title', 'id');
    }

    /**
     * Upload Image to the assets/images directory and return image name for storage
     *
     * @param $request
     * @param $input
     * @return mixed
     */
    public function imageUpload($request, $input)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $name = time() . $image->getClientOriginalName();

            Image::make($image)->resize(500, 500)->save(public_path() . '/assets/images/' . $name);

            $input['image'] = $name;

            return $input;
        }

        return $input;
    }

}