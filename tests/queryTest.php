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
 * @author    Anthony Fuentes <fuentesa@purdue.edu>
 * @copyright Copyright 2005-2015 HUBzero Foundation, LLC.
 * @license   http://opensource.org/licenses/MIT MIT
 */

namespace Components\Forms\Tests;

$componentPath = Component::path('com_forms');

require_once "$componentPath/helpers/criterion.php";
require_once "$componentPath/helpers/query.php";

use Exception;
use Hubzero\Test\Basic;
use Components\Forms\Helpers\Criterion;
use Components\Forms\Helpers\Query;

class QueryTest extends Basic
{

	public function testSavedInvokesSetOnSession()
	{
		$session = $this->getMockBuilder('Session')
			->setMethods(['set'])
			->getMock();
		$query = new Query(['session' => $session]);

		$session->expects($this->once())
			->method('set');

		$query->save();
	}

	public function testLoadReturnsQueryInstance()
	{
		$session = $this->getMockBuilder('Session')
			->setMethods(['get'])
			->getMock();
		$session->method('get')->willReturn([]);

		$query = Query::load(['session' => $session]);
		$queryClass = get_class($query);

		$this->assertEquals('Components\Forms\Helpers\Query', $queryClass);
	}

	public function testToArray()
	{
		$testCriteria = [
			'name' => new Criterion([
				'name' => 'name',
				'operator' => '=',
				'value' => 'a'
			]),
			'number' => new Criterion([
				'name' => 'number',
				'operator' => '>',
				'value' => 3
			])
		];
		$query = new Query();

		foreach ($testCriteria as $criterion)
		{
			$query->set($criterion->name, $criterion->toArray());
		}

		$queryArray = $query->toArray();

		$this->assertEquals($testCriteria, $queryArray);
	}

	public function testGetReturnsNullIfAttributeAbsent()
	{
		$query = new Query();

		$actualValue = $query->get('a');

		$this->assertEquals(null, $actualValue);
	}

	public function testSetAssociative()
	{
		$criteriaData = [
			'name' => [
				'name' => 'name',
				'operator' => '=',
				'value' => 'a'
			],
			'number' =>	[
				'name' => 'number',
				'operator' => '>',
				'value' => 3
			]
		];
		$expectedCriteria = array_map(function($criterionData) use($criteriaData) {
			return new Criterion($criterionData);
		}, $criteriaData);
		$query = new Query();

		$query->setAssociative($criteriaData);
		$queryArray = $query->toArray();

		$this->assertEquals($expectedCriteria, $queryArray);
	}

	public function testGetReturnsCriterion()
	{
		$query = new Query();
		$key = 'a';
		$criterionData = [
			'operator' => '<=',
			'value' => 49,
		];
		$expectedValue = new Criterion(
			array_merge(['name' => $key], $criterionData)
		);

		$query->set($key, $criterionData);
		$actualValue = $query->get('a');

		$this->assertEquals($expectedValue, $actualValue);
	}

	public function testGetValueReturnsCorrectValue()
	{
		$expectedValue = 'test';
		$key = 'a';
		$query = new Query();
		$criterionData = [
			'operator' => '',
			'value' => $expectedValue
		];

		$query->set($key, $criterionData);
		$actualValue = $query->getValue($key);

		$this->assertEquals($expectedValue, $actualValue);
	}

	public function testGetValueReturnsNullIfAttributeAbsent()
	{
		$query = new Query();

		$actualValue = $query->getValue('absent');

		$this->assertEquals(null, $actualValue);
	}


	public function testConstructSetsDefaultName()
	{
		$query = new Query();

		$name = $query->name;

		$this->assertEquals(Query::$defaultName, $name);
	}

	public function testConstructSetsGivenName()
	{
		$state = ['name' => 'test'];
		$query = new Query($state);

		$name = $query->name;

		$this->assertEquals($state['name'], $name);
	}

	public function testConstructSetsDefaultNamespace()
	{
		$query = new Query();

		$namespace = $query->namespace;

		$this->assertEquals(Query::$defaultNamespace, $namespace);
	}

	public function testConstructSetsGivenNamespace()
	{
		$state = ['namespace' => 'test'];
		$query = new Query($state);

		$namespace = $query->namespace;

		$this->assertEquals($state['namespace'], $namespace);
	}

	public function testNewQueryReturnsEmptyErrorsArray()
	{
		$query = new Query();

		$errors = $query->getErrors();

		$this->assertEquals([], $errors);
	}

}
