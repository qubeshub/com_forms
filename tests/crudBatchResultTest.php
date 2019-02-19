<?php
/**
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

namespace Components\Forms\Tests;

$componentPath = Component::path('com_forms');

require_once "$componentPath/helpers/crudBatchResult.php";
require_once "$componentPath/tests/helpers/canMock.php";

use Hubzero\Test\Basic;
use Components\Forms\Helpers\CrudBatchResult;
use Components\Forms\Tests\Traits\canMock;

class CrudBatchResultTest extends Basic
{
	use canMock;

	public function testSucceededReturnsTrueIfAllBatchesSucceeded()
	{
		$successfulBatchArgs = [
			'class' => 'CrudBatch', 'methods' => ['succeeded' => true]
		];
		$batchA = $this->mock($successfulBatchArgs);
		$batchB = $this->mock($successfulBatchArgs);
		$batches = [$batchA, $batchB];
		$crudBatchResult = new CrudBatchResult(['batches' => $batches]);

		$succeeded = $crudBatchResult->succeeded();

		$this->assertEquals(true, $succeeded);
	}

	public function testSucceededReturnsTrueIfAnyBatchesFailed()
	{
		$batchA = $this->mock([
			'class' => 'CrudBatch', 'methods' => ['succeeded' => true]
		]);
		$batchB = $this->mock([
			'class' => 'CrudBatch', 'methods' => ['succeeded' => false]
		]);
		$batches = [$batchA, $batchB];
		$crudBatchResult = new CrudBatchResult(['batches' => $batches]);

		$succeeded = $crudBatchResult->succeeded();

		$this->assertEquals(false, $succeeded);
	}

	public function testGetFailedSavesReturnsAllBatchesFailedSaves()
	{
		$batchA = $this->mock([
			'class' => 'CrudBatch', 'methods' => ['getFailedSaves' => []]
		]);
		$batchB = $this->mock([
			'class' => 'CrudBatch', 'methods' => ['getFailedSaves' => [1, 2]]
		]);
		$batchC = $this->mock([
			'class' => 'CrudBatch', 'methods' => ['getFailedSaves' => [3, 4]]
		]);
		$batches = [$batchA, $batchB, $batchC];
		$crudBatchResult = new CrudBatchResult(['batches' => $batches]);

		$failedSaves = $crudBatchResult->getFailedSaves();

		$this->assertEquals([1,2, 3, 4], $failedSaves);
	}

	public function testGetFailedDestorysReturnsAllBatchesFailedDestroys()
	{
		$batchA = $this->mock([
			'class' => 'CrudBatch', 'methods' => ['getFailedDestroys' => []]
		]);
		$batchB = $this->mock([
			'class' => 'CrudBatch', 'methods' => ['getFailedDestroys' => [1, 2]]
		]);
		$batchC = $this->mock([
			'class' => 'CrudBatch', 'methods' => ['getFailedDestroys' => [3, 4]]
		]);
		$batches = [$batchA, $batchB, $batchC];
		$crudBatchResult = new CrudBatchResult(['batches' => $batches]);

		$failedDesroys = $crudBatchResult->getFailedDestroys();

		$this->assertEquals([1,2, 3, 4], $failedDesroys);
	}

	public function testGetErrorsReturnsCorrectErrors()
	{
		$recordA = $this->mock([
			'class' => 'Relational',
			'methods' => ['get' => 1, 'getErrors' => ['a']]
		]);
		$recordB = $this->mock([
			'class' => 'Relational',
			'methods' => ['get' => 2, 'getErrors' => ['b']]
		]);
		$batch = $this->mock([
			'class' => 'CrudBatch',
			'methods' => ['getFailedSaves' => [$recordA, $recordB]]
		]);
		$result = new CrudBatchResult(['batches' => [$batch]]);

		$errors = $result->getErrors();

		$this->assertEquals(['Record 1' => ['a'], 'Record 2' => ['b']], $errors);
	}

}
