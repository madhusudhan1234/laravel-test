<?php
use repository\CartRepository;
use repository\ProductRepository;

/**
 * Class CartController
 */
class CartController extends \BaseController {

	/**
	 * @var CartRepository
     */
	private $carts;
	/**
	 * @var ProductRepository
     */
	private $products;


	/**
	 * CartController constructor.
	 * @param ProductRepository $products
	 * @param CartRepository $carts
     */
	public function __construct(ProductRepository $products, CartRepository $carts)
	{
		$this->products = $products;
		$this->carts = $carts;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$carts = $this->carts->all();

		return View::make('frontend.carts.index',compact('carts'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$rules = array(
			'quantity' => 'required',
		);

		$validation= Validator::make(Input::all(),$rules);

		if($validation->passes())
		{
			$cart = new Cart();
			$cart->product_id = Input::get('product_id');
			$cart->user_id = 1;
			$cart->price = Input::get('price');
			$cart->status = 1;
			$cart->quantity = Input::get('quantity');
			$cart->total = Input::get('quantity') * Input::get('price');
			$this->carts->save($cart);

			return Redirect::route('carts.index')
				->withInput()
				->withErrors($validation)
				->with('message', 'Successfully created Cart.');
		}

		return Redirect::route('carts.create')
			->withInput()
			->withErrors($validation)
			->with('message', 'Some fields are Cart.');
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$product = $this->products->find($id);

		return View::make('frontend.carts.create',compact('product'));
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{

	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$cart = $this->carts->find($id);
		
		$this->carts->delete($cart);

		return Redirect::route('users.index')
			->withInput()
			->with('message', 'Successfully deleted User.');
		
	}


}
