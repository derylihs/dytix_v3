<?php

class UsersController extends \BaseController {
	protected $layout = "layouts.main";
	/**
	 * Display a listing of the resource.
	 * GET /users
	 *
	 * @return Response
	 */
	public function __construct() {
    	$this->beforeFilter('csrf', array('on'=>'post'));
    	$this->beforeFilter('auth', array('only'=>array('getDashboard')));
	}
	public function getIndex()
	{
		$this->layout->content = View::make('users.login');
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /users/create
	 *
	 * @return Response
	 */
	public function postCreate()
	{
		 $validator = Validator::make(Input::all(), User::$rules);
 
	    if ($validator->passes()) {
	        $user = new User;
		    $user->firstname = Input::get('firstname');
		    $user->lastname = Input::get('lastname');
		    $user->email = Input::get('email');
		    $user->password = Hash::make(Input::get('password'));
		    $user->save();
		 
		    return Redirect::to('users/login')->with(array(
		    	'message' => 'Thanks for registering!',
		    	'status' => 'success'
		    	));
	    } else {
	        return Redirect::to('users/register')
	        	->with(array(
	        		'message' => '<strong>Failed!</strong><br>The following errors occurred',
	        		'status' => 'danger',
	        		'error' => '1'
	        		))
	        	->withErrors($validator)
	        	->withInput();    
	    }
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /users
	 *
	 * @return Response
	 */
	public function postIndex()
	{
		if (Auth::attempt(array('email'=>Input::get('email'), 'password'=>Input::get('password')))) {
    		return Redirect::to('users/dashboard')->with('message', 'You are now logged in!');
		} else {
		    return Redirect::to('users/login')
		        ->with('message', 'Your username/password combination was incorrect')
		        ->withInput();
		}
	}

	/**
	 * Display the specified resource.
	 * GET /users/{id}
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
	 * GET /users/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /users/{id}
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
	 * DELETE /users/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	public function getRegister()
	{
		$this->layout->content = View::make('users.register');
	}
	
	public function getLogin()
	{
		$this->layout->content = View::make('users.login');
	}

	public function getDashboard() {
	    $this->layout->content = View::make('users.dashboard');
	}

}