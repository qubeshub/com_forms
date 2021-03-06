<?php
/**
 * @package    hubzero-cms
 * @copyright  Copyright (c) 2005-2020 The Regents of the University of California.
 * @license    http://opensource.org/licenses/MIT MIT
 */

namespace Components\Forms\Tests;

$componentPath = Component::path('com_forms');

require_once "$componentPath/helpers/prerequisiteScopeClassMap.php";

use Hubzero\Test\Basic;
use Components\Forms\Helpers\PrerequisiteScopeClassMap;

class PrerequisiteScopeClassMapTest extends Basic
{

	public function testFormsFormsScopeReturnsCorrectClass()
	{
		$map = new PrerequisiteScopeClassMap();

		$class = $map->getClass('forms_forms');

		$this->assertEquals('Components\Forms\Models\Form', $class);
	}

}
