<?php

namespace Tests\Bleicker\FastRouter\Unit;

use Bleicker\FastRouter\Router;
use Tests\Bleicker\FastRouter\Unit\Fixtures\ExampleController;
use Tests\Bleicker\FastRouter\UnitTestCase;

/**
 * Class RouterTest
 *
 * @package Tests\Bleicker\FastRouter\Unit
 */
class RouterTest extends UnitTestCase {

	/**
	 * @var Router
	 */
	protected $router;

	protected function setUp() {
		parent::setUp();
		$this->router = Router::create();
	}

	/**
	 * @test
	 */
	public function foundTest() {
		$result = $this->router->addRoute(ExampleController::class, 'indexAction', 'foo/{name}', 'get')->dispatch('foo/bleicker', 'get');
		$this->assertEquals(Router::FOUND, $result->getStatus());
		$this->assertArrayHasKey('name', $result->getArguments());
		$this->assertEquals('bleicker', $result->getArguments()['name']);
	}

	/**
	 * @test
	 */
	public function nodFoundTest() {
		$result = $this->router->addRoute(ExampleController::class, 'indexAction', 'foo/{name}', 'get')->dispatch('bar/bleicker', 'get');
		$this->assertEquals(Router::NOT_FOUND, $result->getStatus());
	}

	/**
	 * @test
	 */
	public function notAllowedTest() {
		$result = $this->router->addRoute(ExampleController::class, 'indexAction', 'foo/{name}', 'get')->dispatch('foo/bleicker', 'post');
		$this->assertEquals(Router::METHOD_NOT_ALLOWED, $result->getStatus());
	}
}
