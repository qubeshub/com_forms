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

class AssociationReadResult
{

	/**
	 * Constructs AssociationReadResult instance
	 *
	 * @param    array   $args   Instantiation state
	 * @return   void
	 */
	public function __construct($args = [])
	{
		$this->_data = null;
		$this->_accessor = $args['accessor'];
		$this->_model = $args['model'];
	}

	/**
	 * Indicates whether read succeeded
	 *
	 * @return   bool
	 */
	public function succeeded()
	{
		$modelIsNew = $this->_model->isNew();

		$readSucceeded = $this->_retrieveAssociations();

		return !$modelIsNew && $readSucceeded;
	}

	/**
	 * Getter for _data attribute
	 *
	 * @return   mixed
	 */
	public function getData()
	{
		if ($this->_data === null)
		{
			$this->_retrieveAssociations();
		}

		return $this->_data;
	}

	/**
	 * Retrieves associations from object using given accessor
	 *
	 * @return   bool
	 */
	protected function _retrieveAssociations()
	{
		try
		{
			$accessor = $this->_accessor;
			$this->_data = $this->_model->$accessor();
			$readSucceeded = true;
		}
		catch (Exception $e)
		{
			$readSucceeded = false;
		}

		return $readSucceeded;
	}

}
