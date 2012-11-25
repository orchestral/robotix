<?php

/*
|--------------------------------------------------------------------------
| Robotix Route
|--------------------------------------------------------------------------
|
| Robots.txt should be located at the main `robots.txt` url.
|
*/

Route::any('robots.txt', function ()
{
	// Make sure profiler is off.
	Config::set('application.profiler', false);

	$robots = Orchestra\Core::memory()->get('site.robots-txt', '');
	$headers['Content-Type'] = 'text/plain; charset=utf-8';

	return Response::make($robots, 200, $headers);
});
