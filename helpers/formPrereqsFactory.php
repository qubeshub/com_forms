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

$compnentPath = Component::path('com_forms');

require_once "$componentPath/helpers/batchUpdateHelper.php";
require_once "$componentPath/helpers/crudBatchResult.php";
require_once "$componentPath/helpers/factory.php";

use Components\Forms\Helpers\BatchUpdateHelper;
use Components\Forms\Helpers\CrudBatchResult;
use Components\Forms\Helpers\Factory;
use Hubzero\Utility\Arr;

class FormPrereqsFactory extends Factory
{

	protected $_modelName;

	/**
	 * Constructs FormPrereqsFactory instance
	 *
	 * @param    array   $args   Instantiation state
	 * @return   void
	 */
	public function __construct($args = [])
	{
		$this->_batchUpdateHelper = Arr::getValue($args, 'assoc_helper', new BatchUpdateHelper());
		$args['model_name'] = 'Components\Forms\Models\FormPrerequisite';

		parent::__construct($args);
	}

	/**
	 * Updates given forms associated prerequisites
	 *
	 * @param    object   $currentPrereqs   Form's current prerequisites
	 * @param    array    $newPrereqsData   Submitted prerequisites' data
	 * @return   object
	 */
	public function updateFormsPrereqs($currentPrereqs, $newPrereqsData)
	{
		$updateDelta = $this->_calculateUpdateDelta($currentPrereqs, $newPrereqsData);

		$updateResult = $this->_resolveUpdateDelta($updateDelta);

		return $updateResult;
	}

	/**
	 * Determines which field records are being added, updated, or removed
	 *
	 * @param    object   $currentPrereqs   Form's current prerequisites
	 * @param    array    $newPrereqsData   Submitted prerequisites' data
	 * @return   object
	 */
	protected function _calculateUpdateDelta($currentPrereqs, $newPrereqsData)
	{
		$submittedPrereqs = $this->instantiateMany($newPrereqsData);

		$updateDelta = $this->_batchUpdateHelper->updateDelta(
			$currentPrereqs,
			$submittedPrereqs
		);

		return $updateDelta;
	}

	/**
	 * Saves, creates, or destroys fields based on update delta
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

}

