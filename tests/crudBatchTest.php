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

require_once "$componentPath/helpers/crudBatch.php";

use Hubzero\Test\Basic;
use Components\Forms\Helpers\CrudBatch;

class CrudBatchTest extends Basic
{

	public function testSucceededReturnsTrueIfNoFailedSaves()
	{
		$crudBatch = new CrudBatch();

		$succeeded = $crudBatch->succeeded();

		$this->assertEquals(true, $succeeded);
	}

	public function testSucceededReturnsFalseIfFailedSave()
	{
		$crudBatch = new CrudBatch();

		$crudBatch->addFailedSave([]);
		$succeeded = $crudBatch->succeeded();

		$this->assertEquals(false, $succeeded);
	}

	public function testSucceededReturnsTrueIfNoFailedDestroys()
	{
		$crudBatch = new CrudBatch();

		$succeeded = $crudBatch->succeeded();

		$this->assertEquals(true, $succeeded);
	}

	public function testSucceededReturnsFalseIfFailedDestroy()
	{
		$crudBatch = new CrudBatch();

		$crudBatch->addFailedDestroy([]);
		$succeeded = $crudBatch->succeeded();

		$this->assertEquals(false, $succeeded);
	}

	public function testNewBatchGetFailedSavesReturnsEmptyArray()
	{
		$crudBatch = new CrudBatch();

		$failedSaves = $crudBatch->getFailedSaves();

		$this->assertEquals([], $failedSaves);
	}

	public function testBatchGetFailedSavesReturnsFailedSaves()
	{
		$crudBatch = new CrudBatch();
		$crudBatch->addFailedSave(1);
		$crudBatch->addFailedSave(2);

		$failedSaves = $crudBatch->getFailedSaves();

		$this->assertEquals([1, 2], $failedSaves);
	}

	public function testNewBatchGetFailedDestroysReturnsEmptyArray()
	{
		$crudBatch = new CrudBatch();

		$failedDestroys = $crudBatch->getFailedDestroys();

		$this->assertEquals([], $failedDestroys);
	}

	public function testBatchGetFailedDestroysReturnsFailedDestroys()
	{
		$crudBatch = new CrudBatch();
		$crudBatch->addFailedDestroy(1);
		$crudBatch->addFailedDestroy(2);

		$failedDestroys = $crudBatch->getFailedDestroys();

		$this->assertEquals([1, 2], $failedDestroys);
	}

}
