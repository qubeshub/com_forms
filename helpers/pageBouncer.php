<?php
/**
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
 * @author    Anthony Fuentes <fuentesa@purdue.edu>
 * @copyright Copyright 2005-2015 HUBzero Foundation, LLC.
 * @license   http://opensource.org/licenses/MIT MIT
 */

namespace Components\Forms\Helpers;

$componentPath = Component::path('com_forms');

use Components\Forms\Helpers\MockProxy;
use Hubzero\Utility\Arr;

class PageBouncer
{

	/**
	 * Name of component
	 *
	 * @var   string
	 */
	protected $_componentName;

	/**
	 * Authorization service
	 *
	 * @var   object
	 */
	protected $_permitter;

	/**
	 * Routing service
	 *
	 * @var   object
	 */
	protected $_router;

	/**
	 * Constructs PageBouncer instance
	 *
	 * @param    array   $args   Instantiation state
	 * @return   void
	 */
	public function __construct($args = [])
	{
		$this->_componentName = $args['component'];
		$this->_permitter = Arr::getValue($args, 'permitter', new MockProxy(['class' => 'User']));
		$this->_router = Arr::getValue($args, 'router', new MockProxy(['class' => 'App']));
	}

	/**
	 * Redirects users without given permission
	 *
	 * @param    string   $permission   Permission name
	 * @return   void
	 */
	public function redirectUnlessAuthorized($permission, $url = '/')
	{
		$isAuthorized = $this->_currentIsAuthorized($permission);

		if (!$isAuthorized)
		{
			$this->_router->redirect($url);
		}
	}

	/**
	 * Determines if current user has necessary permission
	 *
	 * @param    string   $permission   Permission name
	 * @return   bool
	 */
	protected function _currentIsAuthorized($permission)
	{
		$component = $this->_componentName;

		$isAuthorized = $this->_permitter->authorize($permission, $component);

		return $isAuthorized;
	}

}
