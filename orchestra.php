<?php

/*
|--------------------------------------------------------------------------
| Register Robotix as Orchestra Resources
|--------------------------------------------------------------------------
|
| Wait for `orchestra.started` to add this event.
|
*/

Event::listen('orchestra.started', function ()
{
	$robots = Orchestra\Resources::make('robotix', array(
		'name' => 'Robots.txt',
		'uses' => 'robotix::home',
	));
});
