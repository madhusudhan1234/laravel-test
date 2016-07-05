<?php

use Intervention\Image\Facades\Image;
use repository\ProductRepository;
use repository\UserRepository;

class ProductController extends \BaseController {

	/**
	 * @var ProductRepository
     */
	private $products;

	/**
	 * @var UserRepository
     */
	private $users;
	/**
	 * ProductController constructor.
	 * @param ProductRepository $products
     */
	public function __construct(ProductRepository $products, UserRepository $users)
	{
		$this->beforeFilter('auth', array('except'=>'show'));

		$this->products = $products;
		$this->users = $users;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$products = $this->products->all();

		return View::make('backend.products.index',compact('products'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('backend.products.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

		$rules=array(
			'title'=>'required|min:2',
			'price'=>'required',
			'description'=>'required|min:5',
			'image' => 'required'
		);
		
		$validation= Validator::make(Input::all(),$rules);
		
		if($validation->passes())
		{
			$product = new Product;
			$product->title = Input::get('title');
			$product->price = Input::get('price');
			$product->description = Input::get('description');
			$product->user_id = Auth::user()->id;
			if (Input::hasFile('image'))
			{
				$file = Input::file('image');
				$name = time().$file->getClientOriginalName();
				Image::make($file)->resize(500,500)->save(public_path() . '/assets/images/' . $name);
			}
			$product->image= $name;

			$this->products->save($product);

			return Redirect::route('products.index')
				->withInput()
				->withErrors($validation)
				->with('message', 'Successfully created Product.');
		}

		return Redirect::route('products.create')
			->withInput()
			->withErrors($validation)
			->with('message', 'Some fields are incomplete.');
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{

	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$product = $this->products->find($id);

		return View::make('backend.products.edit',compact('product'));
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//create a rule validation
		$rules=array(
			'title'=>'required|min:2',
			'price'=>'required',
			'description'=>'required|min:5',
		);

		$input = Input::all();
		$validation = Validator::make($input, $rules);
		if ($validation->passes())
		{
			$product = $this->products->find($id);

			$product->title = Input::get('title');
			$product->price = Input::get('price');
			$product->description = Input::get('description');
			$product->user_id = Auth::user()->id;
			if (Input::hasFile('image'))
			{
				$file = Input::file('image');
				$name = time().$file->getClientOriginalName();
				Image::make($file)->resize(500,500)->save(public_path() . '/assets/images/' . $name);
				$product->image= $name;
			}

			$this->products->save($product);

			return Redirect::route('products.index')
				->withInput()
				->withErrors($validation)
				->with('message', 'Successfully created Product.');
		}
		return Redirect::route('products.edit', $id)
			->withInput()
			->withErrors($validation)
			->with('message', 'There were validation errors.');
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$product = $this->products->find($id);
		$this->products->delete($product);
		return Redirect::route('products.index')
			->withInput()
			->with('message', 'Successfully deleted User.');
	}


}
