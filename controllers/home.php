<?php

use Orchestra\Messages,
	Orchestra\View;

class Robotix_Home_Controller extends Controller {

	/**
	 * Use Restful verb.
	 *
	 * @var  string
	 */
	public $restful = true;

	/**
	 * Apply filters during construct
	 */
	public function __construct()
	{
		$this->filter('before', 'orchestra::manage');
	}

	/**
	 * Show a list of robots.txt
	 *
	 * @access public
	 * @return Response
	 */
	public function get_index()
	{
		$memory = Orchestra\Core::memory();
		$robots = $memory->get('site.robots-txt', '');

		View::share('_title_', 'Robots.txt');

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

		$m = new Messages;
		$v = Validator::make($input, $rules);

		if ($v->fails())
		{
			return Redirect::to(handles('orchestra::resources/robotix'))
				->with_input()
				->with_errors($v);
		}

		$memory = Orchestra\Core::memory();
		$memory->put('site.robots-txt', $input['robots']);

		$m->add('success', __('robotix::response.update'));

		return Redirect::to(handles('orchestra::resources/robotix'))
			->with('message', $m->serialize());
	}
}
