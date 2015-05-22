<?php

namespace Bleicker\FastRouter;

use Bleicker\Routing\Route as RouteOrigin;

/**
 * Class Route
 *
 * @package Bleicker\FastRouter
 */
class Route extends RouteOrigin {

	/**
	 * @param array $properties
	 * @return static
	 */
	public static function __set_state($properties = array()) {
		return new static($properties['className'], $properties['methodName'], $properties['pattern'], $properties['method']);
	}

}
