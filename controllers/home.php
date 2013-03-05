<?php

use Orchestra\Messages,
	Orchestra\Site,
	Orchestra\View;

class Robotix_Home_Controller extends Controller {

	/**
	 * Use Restful verb.
	 *
	 * @var  string
	 */
	public $restful = true;

	/**
	 * Apply filters during construct.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		$this->filter('before', 'orchestra::manage');
		
		parent::__construct();
	}

	/**
	 * Show a list of robots.txt
	 *
	 * @access public
	 * @return Response
	 */
	public function get_index()
	{
		$memory = Orchestra::memory();
		$robots = $memory->get('site.robots-txt', '');

		Site::set('title', 'Robots.txt');

		return View::make('robotix::home', compact('robots'));
	}

	/**
	 * Update robots.txt
	 *
	 * @access public
	 * @return Response
	 */
	public function post_index()
	{
		$input = Input::all();
		$rules = array(
			'robots' => 'required',
		);

		$msg = new Messages;
		$val = Validator::make($input, $rules);

		if ($val->fails())
		{
			return Redirect::to(handles('orchestra::resources/robotix'))
				->with_input()
				->with_errors($val);
		}

		$memory = Orchestra::memory();
		$memory->put('site.robots-txt', $input['robots']);

		$msg->add('success', __('robotix::response.update'));

		return Redirect::to(handles('orchestra::resources/robotix'))
			->with('message', $msg->serialize());
	}
}
