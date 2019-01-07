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


class ApiBatchUpdateResponse
{

	protected $_updateResult, $_errorMessage, $_successMessage;

	/**
	 * Constructs ApiBatchUpdateResponse instance
	 *
	 * @param    array   $args   Instantiation state
	 * @return   void
	 */
	public function __construct($args = [])
	{
		$this->_updateResult = $args['result'];
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
		if ($this->_updateResult->succeeded())
		{
			$thisAsArray = $this->_updateSucceededArray();
		}
		else
		{
			$thisAsArray = $this->_updateFailedArray();
		}

		return $thisAsArray;
	}

	/**
	 * Returns array representation of this if update succeeded
	 *
	 * @return   array
	 */
	protected function _updateSucceededArray()
	{
		$thisAsArray = [];

		$thisAsArray['status'] = 'success';
		$thisAsArray['message'] = $this->_successMessage;

		return $thisAsArray;
	}

	/**
	 * Returns array representation of this if update failed
	 *
	 * @return   array
	 */
	protected function _updateFailedArray()
	{
		$thisAsArray = [];

		$thisAsArray['status'] = 'error';
		$thisAsArray['message'] = $this->_errorMessage;
		$thisAsArray['models'] = [];
		$thisAsArray['models']['failed_saves'] = $this->_collectFailedSaves();
		$thisAsArray['models']['failed_destroys'] = $this->_collectFailedDestroys();

		return $thisAsArray;
	}

	/**
	 * Collects data of models that failed to persist
	 *
	 * @return   array
	 */
	protected function _collectFailedSaves()
	{
		$failedSaves = $this->_updateResult->getFailedSaves();

		$failedSaves = $this->_collectFailedModelsData($failedSaves);

		return $failedSaves;
	}

	/**
	 * Collects data of models that failed to be destroyed
	 *
	 * @return   array
	 */
	protected function _collectFailedDestroys()
	{
		$failedDestroys = $this->_updateResult->getFailedDestroys();

		$failedDestroys = $this->_collectFailedModelsData($failedDestroys);

		return $failedDestroys;
	}

	/**
	 * Collects failed models IDs and errors
	 *
	 * @param    iterable   $models   Models that CRUD operation failed for
	 * @return   array
	 */
	protected function _collectFailedModelsData($models)
	{
		$modelsData = array_map(function($model) {
			return [
				'id' => $model->get('id'),
				'errors' => $model->getErrors()
			];
		}, $models);

		return $modelsData;
	}

}
