<?php
/*
 * @package   hubzero-cms
 * @copyright Copyright 2005-2015 HUBzero Foundation, LLC.
 * @license   http://opensource.org/licenses/MIT MIT
 */

namespace Components\Forms\Tests;

$componentPath = Component::path('com_forms');

require_once "$componentPath/helpers/addTagsResult.php";
require_once "$componentPath/tests/helpers/canMock.php";

use Hubzero\Test\Basic;
use Components\Forms\Helpers\AddTagsResult;
use Components\Forms\Tests\Traits\canMock;
use stdClass;

class AddTagsResultTest extends Basic
{
	use canMock;

	public function testOneReturnsAnInstance()
	{
		$result = AddTagsResult::one();

		$resultClass = get_class($result);

		$this->assertEquals('Components\Forms\Helpers\AddTagsResult', $resultClass);
	}

	public function testAddFailureAddsFailureObject()
	{
		$record = $this->mock(['class' => 'Relational']);
		$errors = ['test'];
		$expectedObject = new stdClass;
		$expectedObject->record = $record;
		$expectedObject->errors = $errors;
		$result = new AddTagsResult();

		$result->addFailure($record, $errors);
		$failures = $result->getFailures();

		$this->assertEquals($expectedObject, $failures[0]);
	}

	public function testAddSuccessAddsRecordToSuccesses()
	{
		$record = $this->mock(['class' => 'Relational']);
		$expectedObject = new stdClass;
		$expectedObject->record = $record;
		$result = new AddTagsResult();

		$result->addSuccess($record);
		$successes = $result->getSuccesses();

		$this->assertEquals($expectedObject, $successes[0]);
	}

	public function testSucceededIsFalseIfNoTagsAdded()
	{
		$result = new AddTagsResult();

		$succeeded = $result->succeeded();

		$this->assertEquals(false, $succeeded);
	}

	public function testSucceededIsFalseIfFailures()
	{
		$result = new AddTagsResult();

		$result->addFailure(new stdClass, []);
		$succeeded = $result->succeeded();

		$this->assertEquals(false, $succeeded);
	}

	public function testSucceededIsTrueIfTagsAddedWithoutFailures()
	{
		$result = new AddTagsResult();

		$result->addSuccess(new stdClass);
		$succeeded = $result->succeeded();

		$this->assertEquals(true, $succeeded);
	}

	public function testGetErrorsReturnsEmptyArrayIfNoErrors()
	{
		$result = new AddTagsResult();

		$result->addSuccess(new stdClass);
		$errors = $result->getErrors();

		$this->assertEquals([], $errors);
	}

	public function testGetErrorsReturnsErrorsWhenPresent()
	{
		$result = new AddTagsResult();
		$recordA = $this->mock(['class' => 'Relational']);
		$recordA->id = 4;
		$recordA->errors = ['a'];
		$recordB = $this->mock(['class' => 'Relational']);
		$recordB->id = 3;
		$recordB->errors = ['b'];
		$expected = [
			$recordA->id => $recordA->errors,
			$recordB->id => $recordB->errors
		];

		$result->addFailure($recordA, $recordA->errors);
		$result->addFailure($recordB, $recordB->errors);
		$errors = $result->getErrors();

		$this->assertEquals($expected, $errors);
	}

}
