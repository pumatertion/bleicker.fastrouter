<?php

namespace Bleicker\FastRouter;

use Bleicker\Routing\AbstractRouter;
use Bleicker\Routing\RouteDataInterface;
use Closure;
use FastRoute;

/**
 * Class FastRouter
 *
 * @package Bleicker\FastRouter
 */
class Router extends AbstractRouter {

	/**
	 * @var array
	 */
	protected $routes = [];

	/**
	 * @param string $pattern
	 * @param string $method
	 * @param RouteDataInterface $data
	 * @return $this
	 */
	public function addRoute($pattern, $method, RouteDataInterface $data) {
		$route = new Route($method, $pattern, $data);
		$this->routes[] = $route;
		return $this;
	}

	/**
	 * @param string $uri
	 * @param string $method
	 * @return array
	 * @todo introduce cached routing if context === production
	 */
	public function dispatch($uri, $method = 'get') {
		return FastRoute\simpleDispatcher($this->getDispatchClosuce())->dispatch(strtolower($method), strtolower($uri));
	}

	/**
	 * @return Closure
	 */
	protected function getDispatchClosuce() {
		return function (FastRoute\RouteCollector $routeCollector) {
			/** @var Route $route */
			foreach ($this->routes as $route) {
				$routeCollector->addRoute($route->getMethod(), $route->getPattern(), $route);
			}
		};
	}
}
