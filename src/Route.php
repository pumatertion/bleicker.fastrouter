<?php

namespace Bleicker\FastRouter;

use Bleicker\Routing\RouteDataInterface;
use Bleicker\Routing\RouteInterface;

/**
 * Class Route
 *
 * @package Bleicker\FastRouter
 */
class Route implements RouteInterface {

	/**
	 * @var string
	 */
	protected $method;

	/**
	 * @var string
	 */
	protected $pattern;

	/**
	 * @var RouteDataInterface
	 */
	protected $data;

	/**
	 * @param string $method
	 * @param string $pattern
	 * @param RouteDataInterface $data
	 */
	public function __construct($method, $pattern, RouteDataInterface $data) {
		$this->method = $method;
		$this->pattern = $pattern;
		$this->data = $data;
	}

	/**
	 * @param string $method
	 * @return $this
	 */
	public function setMethod($method) {
		$this->method = $method;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getMethod() {
		return $this->method;
	}

	/**
	 * @param string $pattern
	 * @return $this
	 */
	public function setPattern($pattern) {
		$this->pattern = $pattern;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getPattern() {
		return $this->pattern;
	}

	/**
	 * @param RouteDataInterface $data
	 * @return $this
	 */
	public function setData(RouteDataInterface $data) {
		$this->data = $data;
		return $this;
	}

	/**
	 * @return RouteDataInterface
	 */
	public function getData() {
		return $this->data;
	}


}
