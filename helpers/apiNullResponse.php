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

class ApiNullResponse
{

	protected $_errorMessage, $_result, $_status, $_successMessage;

	/**
	 * Constructs ApiNullResponse instance
	 *
	 * @param    array   $args   Instantiation state
	 * @return   void
	 */
	public function __construct($args = [])
	{
		$this->_result = Arr::getValue($args, 'result', null);
		$this->_status = Arr::getValue($args, 'status', '');
		$this->_errorMessage = Arr::getValue($args, 'error_message', '');
		$this->_successMessage = Arr::getValue($args, 'success_message', '');
	}

	/**
	 * Returns array representation of $this
	 *
	 * @return   array
	 */
	public function toArray()
	{
		if ($this->_succeeded())
		{
			$thisAsArray = $this->_succeededArray();
		}
		else
		{
			$thisAsArray = $this->_failedArray();
		}

		return $thisAsArray;
	}

	/**
	 * Returns array representation of this if succeeded
	 *
	 * @return   array
	 */
	protected function _succeededArray()
	{
		$thisAsArray = [];

		$thisAsArray['status'] = 'success';
		$thisAsArray['message'] = $this->_successMessage;

		return $thisAsArray;
	}

	/**
	 * Returns array representation of this if failed
	 *
	 * @return   array
	 */
	protected function _failedArray()
	{
		$thisAsArray = [];

		$thisAsArray['status'] = 'error';
		$thisAsArray['message'] = $this->_errorMessage;

		return $thisAsArray;
	}

	/**
	 * Indicates if result should be considered successful
	 *
	 * return   bool
	 */
	protected function _succeeded()
	{
		$result = $this->_result;
		$resultSucceeded = $result && $result->succeeded();
		$successStatus = $this->_status == 'success';

		$succeeded = $resultSucceeded || $successStatus;

		return $succeeded;
	}

}
