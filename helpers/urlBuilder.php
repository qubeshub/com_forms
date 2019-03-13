<?php
/*
 * @package   hubzero-cms
 * @copyright Copyright 2005-2015 HUBzero Foundation, LLC.
 * @license   http://opensource.org/licenses/MIT MIT
 */

namespace Components\Forms\Helpers;

class UrlBuilder
{

	/**
	 * Generates URL based on given segments and parameters
	 *
	 * @param    array    $segments     URL segments
	 * @param    array    $parameters   URL parameters
	 * @return   string
	 */
	public function generateUrl($segments, $parameters = [])
	{
		$url = '';

		$url = $this->_addSegments($url, $segments);
		$url = $this->_addParameters($url, $parameters);

		return $url;
	}

	/**
	 * Adds segments to URL
	 *
	 * @param    string   $url        URL
	 * @param    array    $segments   URL segments
	 * @return   string
	 */
	protected function _addSegments($url, $segments)
	{
		foreach ($segments as $segment)
		{
			$url .= "/$segment";
		}

		return $url;
	}

	/**
	 * Adds parameters to URL
	 *
	 * @param    string   $url          URL
	 * @param    array    $parameters   URL parameters
	 * @return   string
	 */
	protected function _addParameters($url, $parameters)
	{
		$count = 0;

		foreach ($parameters as $name => $value)
		{
			if ($count === 0)
			{
				$url .= "?$name=$value";
			}
			else
			{
				$url .= "&$name=$value";
			}

			$count++;
		}

		return $url;
	}

}
