<?php
/*
 * @package   hubzero-cms
 * @copyright Copyright 2005-2015 HUBzero Foundation, LLC.
 * @license   http://opensource.org/licenses/MIT MIT
 */

namespace Components\Forms\Tests;

$componentPath = Component::path('com_forms');

require_once "$componentPath/models/pageField.php";

use Hubzero\Test\Basic;
use Components\Forms\Models\PageField;

class PageFieldTest extends Basic
{

	public function testInitiateHasCreated()
	{
		$field = PageField::blank();

		$hasCreated = in_array('created', $field->initiate);

		$this->assertEquals(true, $hasCreated);
	}

	public function testRulesRequiresPageId()
	{
		$field = PageField::blank();

		$validation = $field->rules['page_id'];

		$this->assertEquals('positive', $validation);
	}

	public function testRulesRequiresOrder()
	{
		$field = PageField::blank();

		$validation = $field->rules['order'];

		$this->assertEquals('positive', $validation);
	}

	public function testRulesRequiresType()
	{
		$field = PageField::blank();

		$validation = $field->rules['type'];

		$this->assertEquals('notempty', $validation);
	}

}
