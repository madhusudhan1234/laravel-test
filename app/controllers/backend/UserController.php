<?php

use repository\UserRepository;

class UserController extends \BaseController {

	/**
	 * @var UserRepository
     */
	private $users;

	/**
	 * UserController constructor.
	 * @param UserRepository $users
     */
	public function __construct(UserRepository $users)
	{
		$this->beforeFilter('auth', array());
		$this->users = $users;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$users = $this->users->all();

		return View::make('backend.users.index',compact('users'));

	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('backend.users.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$rules = array(
			'first_name' => 'required|min:2',
			'last_name' => 'required|min:2',
			'email' => 'required|email',
			'password' => 'required|alpha_num|between:6,12|confirmed',
			'password_confirmation' => 'required|alpha_num|between:6,12'
		);
		$validation= Validator::make(Input::all(),$rules);

		if($validation->passes())
		{
			$this->users->save(Input::all());

			return Redirect::route('users.index')
				->withInput()
				->withErrors($validation)
				->with('message', 'Successfully created User.');
		}

		return Redirect::route('users.create')
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
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$user = $this->users->find($id);

		if (is_null($user))
		{
			return Redirect::route('users.index');
		}

		return View::make('backend.users.edit', compact('user'));

	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$rules=array(
			'first_name'=>'required|min:2',
			'last_name'=>'required|min:2',
			'email'=>'required|email'
		);

		$input = Input::all();
		
		$validation = Validator::make($input, $rules);
		
		if ($validation->passes())
		{
			$user = $this->users->find($id);
			$this->users->update($input,$user);
			
			return Redirect::route('users.index')
				->withInput()
				->withErrors($validation)
				->with('message', 'Successfully updated User.');
		}
		return Redirect::route('users.edit', $id)
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
		$user = $this->users->find($id);
		$this->users->delete($user);
		
		return Redirect::route('users.index')
			->withInput()
			->with('message', 'Successfully deleted User.');
	}

}
