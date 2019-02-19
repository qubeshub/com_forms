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

class ListErrorMessage
{

	/**
	 * Constructs ListErrorMessage instance
	 *
	 * @param    array   $args   Instantiation state
	 * @return   void
	 */
	public function __construct($args = [])
	{
		$this->_errorIntro = Arr::getValue($args, 'errorIntro', '');
		$this->_errors = $args['errors'];
	}

	/**
	 * Returns a string representation of $this
	 *
	 * @param    string   $errorIntro   Top level error text
	 * @return   string
	 */
	public function toString($errorIntro = '')
	{
		$errorIntro = $errorIntro ? $errorIntro : $this->_errorIntro;
		$errorMessage = "$this->_errorIntro <br/>";

		foreach ($this->_errors as $key => $error)
		{
			$errorMessage .= $this->_parseError($key, $error);
		}

		$errorMessage = "$errorMessage<br/><br/>";

		return $errorMessage;
	}

	/**
	 * Handles preparing errors for
	 *
	 * @param    string   $key     Key of error(s) in records errors array
	 * @param    mixed    $error   Records error(s)
	 * @return   string
	 */
	protected function _parseError($key, $error)
	{
		if (is_array($error))
		{
			$error = $this->_combineErrors($key, $error);
		}
		else
		{
			$error = $this->_formatError($error);
		}

		return $error;
	}

	/**
	 * Combines the errors of a record into a single message
	 *
	 * @param    string   $topLevelError   Top level erroor message
	 * @param    array    $errors          Records error descriptions
	 * @return   string
	 */
	protected function _combineErrors($topLevelError, $errors)
	{
		$errorMessage = $this->_formatError($topLevelError);

		foreach ($errors as $error)
		{
				$errorMessage .= "<br/>&nbsp;&nbsp;&nbsp; - $error";
		}

		return $errorMessage;
	}

	/**
	 * Formats error for addition to top level of message
	 *
	 * @param    string   $error   Error text
	 * @return   string
	 */
	protected function _formatError($error)
	{
		return "<br/>• $error";
	}

}
