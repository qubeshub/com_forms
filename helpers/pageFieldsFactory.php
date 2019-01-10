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

require_once "$componentPath/helpers/associationReadResult.php";
require_once "$componentPath/helpers/batchUpdateHelper.php";
require_once "$componentPath/helpers/crudBatch.php";
require_once "$componentPath/helpers/crudBatchResult.php";
require_once "$componentPath/helpers/factory.php";

use Components\Forms\Helpers\AssociationReadResult;
use Components\Forms\Helpers\BatchUpdateHelper;
use Components\Forms\Helpers\CrudBatch;
use Components\Forms\Helpers\CrudBatchResult;
use Components\Forms\Helpers\Factory;
use Hubzero\Utility\Arr;

class PageFieldsFactory extends Factory
{

	protected $_modelName;

	/**
	 * Constructs PageFieldsFactory instance
	 *
	 * @param    array   $args   Instantiation state
	 * @return   void
	 */
	public function __construct($args = [])
	{
		$this->_batchUpdateHelper = Arr::getValue($args, 'assoc_helper', new BatchUpdateHelper());
		$args['model_name'] = 'Components\Forms\Models\PageField';

		parent::__construct($args);
	}

	/**
	 * Retrieves given pages associated fields
	 *
	 * @param    object   $page   Given page
	 * @return   object
	 */
	public function readPagesFields($page)
	{
		$readResult = new AssociationReadResult([
			'model' => $page,
			'accessor' => 'getFieldsInArray',
		]);

		return $readResult;
	}

	/**
	 * Updates given pages associated fields
	 *
	 * @param    object   $currentFields   Page's current fields
	 * @param    array    $newFieldsData   Submitted fields' data
	 * @return   object
	 */
	public function updatePagesFields($currentFields, $newFieldsData)
	{
		$updateDelta = $this->_calculateUpdateDelta($currentFields, $newFieldsData);

		$updateResult = $this->_resolveUpdateDelta($updateDelta);

		return $updateResult;
	}

	/**
	 * Determines which field records are being added, updated, or removed
	 *
	 * @param    object   $currentFields         Current fields
	 * @param    array    $submittedFieldsData   Submitted fields' data
	 * @return   object
	 */
	protected function _calculateUpdateDelta($currentFields, $submittedFieldsData)
	{
		$submittedFields = $this->instantiateMany($submittedFieldsData);

		$updateDelta = $this->_batchUpdateHelper->updateDelta(
			$currentFields,
			$submittedFields
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
