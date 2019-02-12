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

class CrudBatchResult
{

	/**
	 * Constructs CrudBatchResult instance
	 *
	 * @param    array   $args   Instantiation state
	 * @return   void
	 */
	public function __construct($args = [])
	{
		$this->_batches = $args['batches'];
	}

	/**
	 * Indicates whether CRUD operations succeeded for all batches
	 *
	 * @return   bool
	 */
	public function succeeded()
	{
		foreach ($this->_batches as $batch)
		{
			if (!$batch->succeeded()) return false;
		}

		return true;
	}

	/**
	 * Returns errors for models that failed to be saved
	 *
	 * @return   bool
	 */
	public function getErrors()
	{
		$failedSaves = $this->getFailedSaves();

		$errors = array_map(function($record) {
			$id = $record->get('id');
			$errors = $record->getErrors();
			array_unshift($errors, "Record $id");
			return $errors;
		}, $failedSaves);

		$errors = array_merge(...$errors);

		return $errors;
	}

	/**
	 * Returns all models that failed to be saved
	 *
	 * @return   bool
	 */
	public function getFailedSaves()
	{
		$failedSaves = array_reduce($this->_batches, function($failedSaves, $batch) {
			return array_merge($failedSaves, $batch->getFailedSaves());
		}, []);

		return $failedSaves;
	}

	/**
	 * Returns all models that failed to be destroyed
	 *
	 * @return   bool
	 */
	public function getFailedDestroys()
	{
		$failedDestroys = array_reduce($this->_batches, function($failedDestroys, $batch) {
			return array_merge($failedDestroys, $batch->getFailedDestroys());
		}, []);

		return $failedDestroys;
	}

}
