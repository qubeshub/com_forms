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

require_once "$componentPath/helpers/criterion.php";
require_once "$componentPath/helpers/relationalSearch.php";

use Hubzero\Test\Basic;
use Components\Forms\Helpers\Criterion;
use Components\Forms\Helpers\RelationalSearch;

class RelationalSearchTest extends Basic
{

	public function testFindBy()
	{
		$criteria = [
			new Criterion([
				'name' => 'disabled',
				'operator' => '=',
				'value' => 1
			]),
			new Criterion([
				'name' => 'priority',
				'operator' => '>',
				'value' => 4
			])
		];
		$relational = $this->getMockBuilder('Relational')
			->setMethods(['all', 'where'])
			->getMock();
		$relational->method('all')->willReturn($relational);
		$search = new RelationalSearch(['class' => $relational]);

		$relational->expects($this->once())
			->method('all');

		$relational->expects($this->exactly(2))
			->method('where')
			->withConsecutive(
				[
					$this->equalTo($criteria[0]->getName()),
					$this->equalTo($criteria[0]->getOperator()),
					$this->equalTo($criteria[0]->getValue())
				],
				[
					$this->equalTo($criteria[1]->getName()),
					$this->equalTo($criteria[1]->getOperator()),
					$this->equalTo($criteria[1]->getValue())
				]
			);

		$search->findBy($criteria);
	}

}
