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

require_once "$componentPath/helpers/batchUpdateHelper.php";
require_once "$componentPath/helpers/crudBatch.php";
require_once "$componentPath/helpers/crudBatchResult.php";
require_once "$componentPath/helpers/mockProxy.php";

use Components\Forms\Helpers\BatchUpdateHelper;
use Components\Forms\Helpers\CrudBatch;
use Components\Forms\Helpers\CrudBatchResult;
use Components\Forms\Helpers\MockProxy;
use Hubzero\Utility\Arr;

class Factory
{

	/**
	 * Constructs Factory instance
	 *
	 * @param    array   $args   Instantiation state
	 * @return   void
	 */
	public function __construct($args = [])
	{
		$this->_batchUpdateHelper = Arr::getValue($args, 'batch_helper', new BatchUpdateHelper());
		$this->_modelName = $args['model_name'];
		$this->_modelClass = Arr::getValue(
			$args, 'model_class', new MockProxy(['class' => $this->_modelName])
		);
	}

	/**
	 * Updates, creates, destroys records based on given data
	 *
	 * @param    object   $currentRecords   Current records
	 * @param    array    $submittedData    Submitted records' data
	 * @return   object
	 */
	public function batchUpdate($existingRecords, $submittedData)
	{
		$updateDelta = $this->_calculateUpdateDelta($existingRecords, $submittedData);

		$updateResult = $this->_resolveUpdateDelta($updateDelta);

		return $updateResult;
	}

	/**
	 * Determines which records are being added, updated, destroyed
	 *
	 * @param    object   $currentRecords   Current records
	 * @param    array    $submittedData    Submitted records' data
	 * @return   object
	 */
	protected function _calculateUpdateDelta($existingRecords, $submittedData)
	{
		$submittedRecords = $this->instantiateMany($submittedData);

		$updateDelta = $this->_batchUpdateHelper->updateDelta(
			$existingRecords,
			$submittedRecords
		);

		return $updateDelta;
	}

	/**
	 * Saves, creates, or destroys records based on update delta
	 *
	 * @param    object   $updateDelta   Update delta
	 * @return   object
	 */
	protected function _resolveUpdateDelta($updateDelta)
	{
		$saveResult = $this->_saveMany($updateDelta->getModelsToSave());
		$destroyResult = $this->_destroyMany($updateDelta->getModelsToDestroy());

		return new CrudBatchResult(['batches' => [$saveResult, $destroyResult]]);
	}


	/**
	 * Instantiates many models using provided data
	 *
	 * @param   array   $modelsData   Data to instantiate models with
	 * @return  array
	 */
	public function instantiateMany($modelsData)
	{
		$models = [];

		foreach ($modelsData as $modelData)
		{
			$model = $this->instantiate($modelData);
			$models[] = $model;
		}

		return $models;
	}

	/**
	 * Instantiate a model using provided data
	 *
	 * @param   array   $modelData   Data to instantiate model with
	 * @return  object
	 */
	public function instantiate($modelData = [])
	{
		$model = $this->_modelClass->blank();

		$model->set($modelData);

		return $model;
	}

	/**
	 * Attempts to save models
	 *
	 * @param   array   $models   Models to save
	 * @return  object
	 */
	protected function _saveMany($models)
	{
		$result = new CrudBatch();

		foreach ($models as $model)
		{
			$this->_save($model, $result);
		}

		return $result;
	}

	/**
	 * Attempts to save a model
	 *
	 * @param   object   $model    Model to save
	 * @param   object   $result   Trackss outcome of saving model
	 * @return  void
	 */
	protected function _save($model, $result)
	{
		if (!$model->save())
		{
			$result->addFailedSave($model);
		}
		else
		{
			$result->addSuccessfulSave($model);
		}
	}

	/**
	 * Attempts to destroy models
	 *
	 * @param   array   $models   Models to destroy
	 * @return  object
	 */
	protected function _destroyMany($models)
	{
		$result = new CrudBatch();

		foreach ($models as $model)
		{
			$this->_destroy($model, $result);
		}

		return $result;
	}

	/**
	 * Attempts to destroys a model
	 *
	 * @param   object   $model    Model to destroy
	 * @param   object   $result   Trackss outcome of destroying model
	 * @return  void
	 */
	protected static function _destroy($model, $result)
	{
		if (!$model->destroy())
		{
			$result->addFailedDestroy($model);
		}
		else
		{
			$result->addSuccessfulDestroy($model);
		}
	}

}
