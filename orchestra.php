<?php

Event::listen('orchestra.started', function ()
{
	$robots = Orchestra\Resources::make('robotix', array(
		'name' => 'Robots.txt',
		'uses' => 'robotix::home',
	));
});
