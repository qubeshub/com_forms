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

class FormsRouter
{

	/**
	 * Constructs ComponentRouter instance
	 *
	 * @param    array   $args   Instantiation state
	 * @return   void
	 */
	public function __construct($args = [])
	{
		$this->_baseUrl = '/forms';
	}

	/**
	 * Generates forms create URL
	 *
	 * @return   string
	 */
	public function formsCreateUrl()
	{
		$segments = ['forms', 'create'];

		$url = $this->_generateUrl($segments);

		return $url;
	}

	/**
	 * Generates forms edit URL
	 *
	 * @param    int      $formId   ID of form to edit
	 * @return   string
	 */
	public function formsEditUrl($formId)
	{
		$segments = ['forms', $formId, 'edit'];

		$url = $this->_generateUrl($segments);

		return $url;
	}

	/**
	 * Generates forms edit URL
	 *
	 * @param    int      $formId   ID of form to edit
	 * @return   string
	 */
	public function formsUpdateUrl($formId)
	{
		$segments = ['forms', $formId, 'update'];

		$url = $this->_generateUrl($segments);

		return $url;
	}

	/**
	 * Generates form list URL
	 *
	 * @return   string
	 */
	public function formListUrl()
	{
		$segments = ['forms', 'list'];

		$url = $this->_generateUrl($segments);

		return $url;
	}

	/**
	 * Generates search update url
	 *
	 * @return   string
	 */
	public function queryUpdateUrl()
	{
		$segments = ['queries', 'update'];

		$url = $this->_generateUrl($segments);

		return $url;
	}

	/**
	 * Generates form display url
	 *
	 * @param    int      $formId   ID of form to edit
	 * @return   string
	 */
	public function formDisplayUrl($formId)
	{
		$segments = ['forms', $formId, 'display'];

		$url = $this->_generateUrl($segments);

		return $url;
	}

	/**
	 * Generates form's pages list url
	 *
	 * @param    int      $formId   ID of form associated with pages
	 * @return   string
	 */
	public function formsPagesUrl($formId)
	{
		$segments = ['pages'];
		$parameters = ['form_id' => $formId];

		$url = $this->_generateUrl($segments, $parameters);

		return $url;
	}

	/**
	 * Generates form's pages new url
	 *
	 * @param    int      $formId   ID of form associated with pages
	 * @return   string
	 */
	public function formsPagesNewUrl($formId)
	{
		$segments = ['pages', 'new'];
		$parameters = ['form_id' => $formId];

		$url = $this->_generateUrl($segments, $parameters);

		return $url;
	}

	/**
	 * Generates form's pages create url
	 *
	 * @param    int      $formId   ID of form associated with pages
	 * @return   string
	 */
	public function formsPagesCreateUrl($formId)
	{
		$segments = ['pages', 'create'];
		$parameters = ['form_id' => $formId];

		$url = $this->_generateUrl($segments, $parameters);

		return $url;
	}

	/**
	 * Generates URL based on given segments
	 *
	 * @param    array    $segments     URL segments
	 * @param    array    $parameters   URL parameters
	 * @return   string
	 */
	protected function _generateUrl($segments, $parameters = [])
	{
		$url = $this->_baseUrl;

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
		}

		return $url;
	}

}
