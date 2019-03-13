<?php
/*
 * @package   hubzero-cms
 * @copyright Copyright 2005-2015 HUBzero Foundation, LLC.
 * @license   http://opensource.org/licenses/MIT MIT
 */

namespace Components\Forms\Tests;

$componentPath = Component::path('com_forms');

require_once "$componentPath/helpers/eventDispatcher.php";
require_once "$componentPath/tests/helpers/canMock.php";

use Hubzero\Test\Basic;
use Components\Forms\Helpers\EventDispatcher;
use Components\Forms\Tests\Traits\canMock;

class EventDispatcherTest extends Basic
{
	use canMock;

	public function testFieldResponsesUpdateInvokesTrigger()
	{
		$dispatcher = $this->mock([
			'class' => 'Event', 'methods' => ['trigger']
		]);
		$eventDispatcher = new EventDispatcher(['dispatcher' => $dispatcher]);
		$fieldResponses = ['a', 3];

		$dispatcher->expects($this->once())
			->method('trigger')
			->with('forms.onFieldResponsesUpdate', [$fieldResponses]);

		$eventDispatcher->fieldResponsesUpdate($fieldResponses);
	}

}
