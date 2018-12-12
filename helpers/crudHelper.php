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

use Hubzero\Utility\Arr;

$componentPath = Component::path('com_forms');

require_once "$componentPath/helpers/mockProxy.php";

use Components\Forms\Helpers\MockProxy;

class CrudHelper
{

	/**
	 * Constructs CrudHelper instance
	 *
	 * @param    array   $args   Instantiation state
	 * @return   void
	 */
	public function __construct($args = [])
	{
		$this->_errorSummary = Arr::getValue($args, 'errorSummary', '');
		$this->_notify = Arr::getValue($args, 'notify', new MockProxy(['class' => 'Notify']));
		$this->_router = Arr::getValue($args, 'router', new MockProxy(['class' => 'App']));
	}

	/**
	 * Handles successful update of record
	 *
	 * @param    string   $url   URL to redirect user to
	 * @return   void
	 */
	public function successfulUpdate($url)
	{
		$this->_router->redirect($url);
	}

	/**
	 * Handles failed update of record
	 *
	 * @param    object   $record   Record that failed to update
	 * @return   void
	 */
	public function failedUpdate($record)
	{
		$this->_notifyUserOfFailure($record);
	}

	/**
	 * Handles successful creation of record
	 *
	 * @param    string   $url       URL to redirect user to
	 * @param    string   $message   Create sucess message
	 * @return   void
	 */
	public function successfulCreate($url, $message = '')
	{
		$this->_notifyUserOfSuccess($message);

		$this->_router->redirect($url);
	}

	/**
	 * Handles failed creation of record
	 *
	 * @param    object   $record   Record that failed to be created
	 * @return   void
	 */
	public function failedCreate($record)
	{
		$this->_notifyUserOfFailure($record);
	}

	/**
	 * Notifies user of successful record creation
	 *
	 * @param    string   $message   Create sucess message
	 * @return   void
	 */
	protected function _notifyUserOfSuccess($message)
	{
		if (!empty($message))
		{
			$this->_notify->success($message);
		}
	}

	/**
	 * Notifies user of failed record creation
	 *
	 * @param    object   $record   Record that failed to be created
	 * @return   void
	 */
	protected function _notifyUserOfFailure($record)
	{
		$errors = $record->getErrors();

		$errorMessage = $this->_generateErrorMessage($errors);

		$this->_notify->error($errorMessage);
	}

	/**
	 * Generates record creation error message
	 *
	 * @param    array    $errors   Record's errors
	 * @return   void
	 */
	protected function _generateErrorMessage($errors)
	{
		$errorMessage = "$this->_errorSummary <br/>";

		foreach ($errors as $error)
		{
			$errorMessage .= "<br/>• $error";
		}

		return $errorMessage;
	}

}
