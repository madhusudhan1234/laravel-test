<?php

use Illuminate\Support\Facades\Auth;
use repository\ProductRepository;

class HomeController extends BaseController {

	/**
	 * @var
     */
	private $products;

	/**
	 * HomeController constructor.
	 * @param ProductRepository $products
     */
	public function __construct(ProductRepository $products)
	{
		$this->products = $products;
	}

	/**
	 * @return mixed
     */
	public function index()
	{
		$products = $this->products->all();

		return View::make('frontend.welcome',compact('products'));
	}

	/**
	 * @return mixed
     */
	public function getRegister()
	{
		return View::make('frontend.register');
	}

	/**
	 * @return mixed
     */
	public function getLogin()
	{
		return View::make('frontend.login');
	}

	/**
	 * @return mixed
     */
	public function postLogin()
	{
		if (Auth::attempt(array('email'=>Input::get('email'), 'password'=>Input::get('password')))) {
			return Redirect::to('users')->with('message', 'You are now logged in!');
		} else {
			return Redirect::to('users/login')
				->with('message', 'Your username/password combination was incorrect')
				->withInput();
		}
	}

	/**
	 * @return mixed
     */
	public function getLogout()
	{
		Auth::logout();

		return Redirect::to('users/login')->with('message', 'Your are now logged out!');
	}

}
