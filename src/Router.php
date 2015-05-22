<?php

namespace Bleicker\FastRouter;

use Bleicker\Routing\Result;
use Bleicker\Routing\ResultInterface;
use Bleicker\Routing\Route;
use Bleicker\Routing\RouteInterface;
use Bleicker\Routing\RouterInterface;
use Closure;
use FastRoute;
use FastRoute\Dispatcher;
use ReflectionClass;

/**
 * Class Router
 *
 * @package Tests\Bleicker\Routing\Unit\Fixtures
 */
class Router implements RouterInterface {

	const NOT_FOUND = Dispatcher::NOT_FOUND, FOUND = Dispatcher::FOUND, METHOD_NOT_ALLOWED = Dispatcher::METHOD_NOT_ALLOWED;

	/**
	 * @var RouteInterface[]
	 */
	protected $routes = [];

	/**
	 * @var string
	 */
	protected $cacheFile;

	/**
	 * @param string $cacheFile
	 */
	public function __construct($cacheFile = NULL) {
		$this->cacheFile = $cacheFile;
	}

	/**
	 * @param string $cacheFile
	 * @return static
	 */
	public static function create($cacheFile = NULL) {
		$reflection = new ReflectionClass(static::class);
		return $reflection->newInstanceArgs(func_get_args());
	}

	/**
	 * @return boolean
	 */
	public function isCacheEnabled() {
		return (boolean)$this->cacheFile;
	}

	/**
	 * @param string $pattern
	 * @param string $method
	 * @param string $className
	 * @param string $methodName
	 * @return $this
	 */
	public function addRoute($className, $methodName, $pattern, $method = 'get') {
		$this->routes[] = Route::create($className, $methodName, $pattern, $method);
		return $this;
	}

	/**
	 * @return RouteInterface[]
	 */
	public function getRoutes() {
		return $this->routes;
	}

	/**
	 * @param string $uri
	 * @param string $method
	 * @return ResultInterface
	 */
	public function dispatch($uri, $method = 'get') {
		if ($this->isCacheEnabled()) {
			$dispatcher = FastRoute\cachedDispatcher($this->getDispatchClosuce(), ['cacheFile' => $this->cacheFile]);
		} else {
			$dispatcher = FastRoute\simpleDispatcher($this->getDispatchClosuce());
		}
		$routeData = $dispatcher->dispatch(strtolower($method), strtolower($uri));
		$status = $routeData[0];
		switch($status){
			case static::FOUND:
				return Result::create($status, $routeData[1], $routeData[2]);
			default:
				return Result::create($status);
		}
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

