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


class ApiReadResponse
{

	protected $_readResult, $_errorMessage, $_successMessage;

	/**
	 * Constructs ApiReadResponse instance
	 *
	 * @param    array   $args   Instantiation state
	 * @return   void
	 */
	public function __construct($args = [])
	{
		$this->_readResult = $args['result'];
		$this->_errorMessage = $args['error_message'];
		$this->_successMessage = $args['success_message'];
	}

	/**
	 * Returns array representation of $this
	 *
	 * @return   array
	 */
	public function toArray()
	{
		if ($this->_readResult->succeeded())
		{
			$thisAsArray = $this->_readSucceededArray();
		}
		else
		{
			$thisAsArray = $this->_readFailedArray();
		}

		return $thisAsArray;
	}

	/**
	 * Returns array representation of this if read succeeded
	 *
	 * @return   array
	 */
	protected function _readSucceededArray()
	{
		$thisAsArray = [];

		$thisAsArray['status'] = 'success';
		$thisAsArray['message'] = $this->_successMessage;
		$thisAsArray['associations'] = $this->_mapAssociationsToArray();

		return $thisAsArray;
	}

	protected function _mapAssociationsToArray()
	{
		$associations = array_map(function($association) {
			return $association->toArray();
		}, $this->_readResult->getData());

		return $associations;
	}

	/**
	 * Returns array representation of this if read failed
	 *
	 * @return   array
	 */
	protected function _readFailedArray()
	{
		$thisAsArray = [];

		$thisAsArray['status'] = 'error';
		$thisAsArray['message'] = $this->_errorMessage;

		return $thisAsArray;
	}

}