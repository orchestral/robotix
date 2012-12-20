<?php

Bundle::start('orchestra');

class RobotixTest extends Orchestra\Testable\TestCase 
{
	/**
	 * User instance.
	 *
	 * @var Orchestra\Model\User
	 */
	private $user = null;

	/**
	 * Setup test test environment.
	 */
	public function setUp()
	{
		parent::setUp();

		Orchestra\Extension::detect();
		Orchestra\Extension::activate('robotix');

		$this->user = Orchestra\Model\User::find(1);
	}

	/**
	 * Teardown the test environment.
	 */
	public function tearDown()
	{
		unset($this->user);
		Orchestra\Extension::deactivate('robotix');

		parent::tearDown();
	}

	/**
	 * Test Route GET (orchestra)/resources/robotix is successful.
	 *
	 * @test
	 */
	public function testGetResourceIsSuccessful()
	{
		$this->be($this->user);

		$this->assertTrue(Orchestra\Extension::started('robotix'));

		$response = $this->call('orchestra::resources@robotix');

		$this->assertInstanceOf('Laravel\Response', $response);
		$this->assertEquals(200, $response->foundation->getStatusCode());
		$this->assertEquals('orchestra::resources.resources', $response->content->view);

		$content = $response->content->data['content'];

		$this->assertInstanceOf('Laravel\Response', $content);
		$this->assertEquals('robotix::home', $content->content->view);
	}

	/**
	 * Test Route GET (orchestra)/resources/robotix failed without auth.
	 *
	 * @test
	 */
	public function testGetResourceFailedWithoutAuth()
	{
		$this->be(null);

		$this->assertTrue(Orchestra\Extension::started('robotix'));

		$response = $this->call('orchestra::resources@robotix');

		$this->assertInstanceOf('Laravel\Redirect', $response);
		$this->assertEquals(302, $response->foundation->getStatusCode());
		$this->assertEquals(handles('orchestra::login'), 
			$response->foundation->headers->get('location'));
	}

	/**
	 * Test Route POST (orchestra)/resources/robotix is successful.
	 *
	 * @test
	 */
	public function testPostRobotIsSuccessful()
	{
		$this->be($this->user);

		$this->assertTrue(Orchestra\Extension::started('robotix'));

		$response = $this->call('orchestra::resources@robotix', array(), 'POST', array(
			'robots' => 'foobar',
		));

		$this->assertInstanceOf('Laravel\Redirect', $response);
		$this->assertEquals(302, $response->foundation->getStatusCode());
		$this->assertEquals(handles('orchestra::resources/robotix'), 
			$response->foundation->headers->get('location'));

		$robots = value(Router::route('GET', 'robots.txt')->action[0]);

		$this->assertEquals('foobar', $robots->content);
	}
}