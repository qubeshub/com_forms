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
 * @copyright Copyright 2005-2015 HUBzero Foundation, LLC.
 * @license   http://opensource.org/licenses/MIT MIT
 */

namespace Components\Forms\Helpers;

use Components\Forms\Helpers\MockProxy;
use Hubzero\Utility\Arr;

class ComponentAuth
{

	protected $_componentName, $_permitter;

	protected static $_CREATE_PERMISSION = 'core.create';

	/**
	 * Constructs ComponentAuth instance
	 *
	 * @param    array   $args   Instantiation state
	 * @return   void
	 */
	public function __construct($args = [])
	{
		$this->_componentName = $args['component'];
		$this->_permitter = Arr::getValue($args, 'permitter', new MockProxy(['class' => 'User']));
	}

	/**
	 * Determines if current user has necessary permission
	 *
	 * @param    string   $permission   Permission name
	 * @return   bool
	 */
	public function currentIsAuthorized($permission)
	{
		$isAuthorized = $this->_permitter->authorize(
			$permission, $this->_componentName
		);

		return $isAuthorized;
	}

	/**
	 * Determines if current user has component create permissions
	 *
	 * @return   bool
	 */
	public function currentCanCreate()
	{
		$currentCanCreate = $this->currentIsAuthorized(self::$_CREATE_PERMISSION);

		return $currentCanCreate;
	}

}
