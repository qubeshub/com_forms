<?php
/*
 * HUBzero CMS
 *
 * Copyright 2005-2015 HUBzero Foundation, LLC.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * HUBzero is a registered trademark of Purdue University.
 *
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
