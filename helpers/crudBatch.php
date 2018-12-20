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

class CrudBatch
{

	/**
	 * Constructs CrudBatch instance
	 *
	 * @param    array   $args   Instantiation state
	 * @return   void
	 */
	public function __construct($args = [])
	{
		$this->_failedSaves = [];
		$this->_successfulSaves = [];
		$this->_failedDestroys = [];
		$this->_successfulDestroys = [];
	}

	/**
	 * Indicates whether CRUD operations succeed for each mdoel in batch
	 *
	 * @return   bool
	 */
	public function succeeded()
	{
		$succeeded = empty($this->_failedSaves) && empty($this->_failedDestroys);

		return $succeeded;
	}

	/**
	 * Adds model to failed saves
	 *
	 * @param    object   $model   Model that failed to be saved
	 * @return   void
	 */
	public function addFailedSave($model)
	{
		array_push($this->_failedSaves, $model);
	}

	/**
	 * Adds model to successful saves
	 *
	 * @param    object   $model   Model that was saved
	 * @return   void
	 */
	public function addSuccessfulSave($model)
	{
		array_push($this->_successfulSaves, $model);
	}

	/**
	 * Adds model to failed destroys
	 *
	 * @param    object   $model   Model that failed to be destroyed
	 * @return   void
	 */
	public function addFailedDestroy($model)
	{
		array_push($this->_failedDestroys, $model);
	}

	/**
	 * Adds model to successful destroys
	 *
	 * @param    object   $model   Model that was destroyed
	 * @return   void
	 */
	public function addSuccessfulDestroy($model)
	{
		array_push($this->_successfulDestroys, $model);
	}

	/**
	 * Returns all models that failed to be saved
	 *
	 * @return   array
	 */
	public function getFailedSaves()
	{
		return $this->_failedSaves;
	}

	/**
	 * Returns all models that failed to be destroyed
	 *
	 * @return   array
	 */
	public function getFailedDestroys()
	{
		return $this->_failedDestroys;
	}

}
