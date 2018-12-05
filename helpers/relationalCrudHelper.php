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

$componentPath = Component::path('com_forms');

require_once "$componentPath/helpers/crudHelper.php";

use Components\Forms\Helpers\CrudHelper;

class RelationalCrudHelper extends CrudHelper
{

	/**
	 * Constructs RelationalCrudHelper instance
	 *
	 * @param    array   $args   Instantiation state
	 * @return   void
	 */
	public function __construct($args = [])
	{
		$this->_controller = $args['controller'];

		parent::__construct($args);
	}

	/**
	 * Handles successful creation of record based on user inputs
	 *
	 * @param    string   $successMessage   Create sucess message
	 * @param    string   $url              URL to redirect user to
	 * @return   void
	 */
	public function successfulCreate($url, $successMessage = '')
	{
		$this->_notifyUserOfSuccess($successMessage);

		parent::successfulCreate($url);
	}

	/**
	 * Handles failed creation of record based on user inputs
	 *
	 * @param    object   $record   Record that failed to be created
	 * @return   void
	 */
	public function failedCreate($record)
	{
		$this->_forwardUserToNewPage($record);

		parent::failedCreate($record);
	}

	/**
	 * Notifies user of successful record creation
	 *
	 * @param    string   $successMessage   Create sucess message
	 * @return   void
	 */
	protected function _notifyUserOfSuccess($successMessage)
	{
		if (!empty($successMessage))
		{
			$this->_notify->success($successMessage);
		}
	}

	/**
	 * Forwards user to new record creation page
	 *
	 * @param    object   $record   Record that failed to be created
	 * @return   void
	 */
	protected function _forwardUserToNewPage($record)
	{
		$this->_controller->setView(null, 'new');
		$this->_controller->newTask($record);
	}

}
