<?php

use repository\RoleRepository;

class RoleController extends \BaseController
{

    /**
     * @var Role
     */
    private $roles;

    /**
     * RoleController constructor.
     * @param Role $roles
     */
    public function __construct(RoleRepository $roles)
    {
        $this->beforeFilter('auth', array());
        $this->roles = $roles;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $roles = $this->roles->all();

        return View::make('backend.roles.index', compact('roles'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return View::make('backend.roles.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $rules = array(
            'role_name' => 'required|min:2'
        );
        $validation = Validator::make(Input::all(), $rules);

        if ($validation->passes()) {
            $this->roles->save(Input::all());

            return Redirect::route('roles.index')
                ->withInput()
                ->withErrors($validation)
                ->with('message', 'Successfully created Role.');
        }

        return Redirect::route('roles.create')
            ->withInput()
            ->withErrors($validation)
            ->with('message', 'Some fields are incomplete.');
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $role = $this->roles->find($id);

        return View::make('backend.roles.edit', compact('role'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        $rules = array(
            'role_name' => 'required|min:2'
        );

        $input = Input::all();

        $validation = Validator::make($input, $rules);

        if ($validation->passes()) {
            $role = $this->roles->find($id);
            $this->roles->update($input, $role);

            return Redirect::route('roles.index')
                ->withInput()
                ->withErrors($validation)
                ->with('message', 'Successfully updated Role.');
        }
        return Redirect::route('roles.edit', $id)
            ->withInput()
            ->withErrors($validation)
            ->with('message', 'There were validation errors.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $role = $this->roles->find($id);

        $this->roles->delete($role);

        return Redirect::route('roles.index')
            ->with('message', 'Role Successfully Deleted');
    }


}
