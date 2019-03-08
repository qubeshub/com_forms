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

namespace Components\Forms\Tests;

$componentPath = Component::path('com_forms');

require_once "$componentPath/helpers/sortableResponses.php";
require_once "$componentPath/tests/helpers/canMock.php";

use Hubzero\Test\Basic;
use Components\Forms\Helpers\SortableResponses;
use Components\Forms\Tests\Traits\canMock;

class SortableResponsesTest extends Basic
{
	use canMock;

	public function testOrderForwardsOrderToResponsesByDefault()
	{
		$direction = 'asc';
		$field = 'test';
		$responses = $this->mock([
			'class' => 'Relational', 'methods' => ['order']
		]);
		$responses->pagination = null;
		$sortableResponses = new SortableResponses(['responses' => $responses]);

		$responses->expects($this->once())
			->method('order')
			->with($field, $direction);

		$sortableResponses->order($field, $direction);
	}

	public function testOrderingByCompletionPercentageCorrectlyOrdersRecords()
	{
		$rowA = $this->mock([
			'class' => 'Relational', 'methods' => ['requiredCompletionPercentage' => 0]
		]);
		$rowB = $this->mock([
			'class' => 'Relational', 'methods' => ['requiredCompletionPercentage' => 89]
		]);
		$rowC = $this->mock([
			'class' => 'Relational', 'methods' => ['requiredCompletionPercentage' => 90]
		]);
		$rows = $this->mock([
				'class' => 'Rows', 'methods' => ['raw' => [$rowA, $rowB, $rowC]]
		]);
		$sortedRows = [$rowC, $rowB, $rowA];
		$responses = $this->mock([
			'class' => 'Relational',
			'methods' => ['rows' => $rows]
		]);
		$responses->pagination = null;

		$sortableResponses = new SortableResponses(['responses' => $responses]);
		$sortableResponses->order('completion_percentage', 'desc');

		$this->assertEquals($sortedRows, $sortableResponses->rows());
	}

}
