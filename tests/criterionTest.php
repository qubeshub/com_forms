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

require_once "$componentPath/helpers/criterion.php";

use Hubzero\Test\Basic;
use Components\Forms\Helpers\Criterion;

class CriterionTest extends Basic
{

	public function testToArrayReturnsCorrectData()
	{
		$expectedState = [
			'name' => 'foo',
			'operator' => '>',
			'value' => '$',
		];
		$criterion = new Criterion($expectedState);

		$criterionAsArray = $criterion->toArray();

		$this->assertEquals($expectedState, $criterionAsArray);
	}

	public function testIsValidReturnsFalseIfNameNull()
	{
		$criterion = new Criterion([
			'operator' => 'operator',
			'value' => 'value'
		]);

		$isValid = $criterion->isValid();

		$this->assertEquals(false, $isValid);
	}

	public function testIsValidReturnsFalseIfOperatorEmpty()
	{
		$criterion = new Criterion([
			'name' => 'name',
			'operator' => '',
			'value' => 'value'
		]);

		$isValid = $criterion->isValid();

		$this->assertEquals(false, $isValid);
	}

	public function testIsValidReturnsFalseIfValueNull()
	{
		$criterion = new Criterion([
			'name' => 'name',
			'operator' => 'operator'
		]);

		$isValid = $criterion->isValid();

		$this->assertEquals(false, $isValid);
	}

	public function testConstructSetsName()
	{
		$name = 'foo';
		$criterion = new Criterion([
			'name' => $name
		]);

		$actualName = $criterion->getName();

		$this->assertEquals($name, $actualName);
	}

	public function testConstructSetsOperator()
	{
		$operator = '>';
		$criterion = new Criterion([
			'operator' => $operator
		]);

		$actualOperator = $criterion->getOperator();

		$this->assertEquals($operator, $actualOperator);
	}

	public function testConstructSetsValue()
	{
		$value = '$';
		$criterion = new Criterion([
			'value' => $value
		]);

		$actualValue = $criterion->getValue();

		$this->assertEquals($value, $actualValue);
	}

}
