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

require_once "$componentPath/helpers/relationalCrudHelper.php";
require_once "$componentPath/tests/helpers/canMock.php";

use Hubzero\Test\Basic;
use Components\Forms\Helpers\RelationalCrudHelper as CrudHelper;
use Components\Forms\Tests\Traits\canMock;

class RelationalCrudHelperTest extends Basic
{
	use canMock;

	public function testFailedCreateInvokesSetView()
	{
		$controller = $this->mock([
			'class' => 'SiteController',
			'methods' => ['setView', 'newTask'],
			'props' => ['name' => '']
		]);
		$notify = $this->mock(['class' => 'Notify', 'methods' => ['error']]);
		$record = $this->mock([
			'class' => 'Relational', 'methods' => ['getErrors' => []]
		]);
		$crudHelper = new CrudHelper([
			'controller' => $controller,
			'notify' => $notify
		]);

		$controller->expects($this->once())
			->method('setView')
			->with(
				$this->equalTo(null),
				$this->equalTo('new')
			);

		$crudHelper->failedCreate($record, '');
	}

	public function testFailedCreateInvokesNewTask()
	{
		$controller = $this->mock([
			'class' => 'SiteController',
			'methods' => ['setView', 'newTask'],
			'props' => ['name' => '']
		]);
		$notify = $this->mock(['class' => 'Notify', 'methods' => ['error']]);
		$record = $this->mock([
			'class' => 'Relational', 'methods' => ['getErrors' => []]
		]);
		$crudHelper = new CrudHelper([
			'controller' => $controller,
			'notify' => $notify
		]);

		$controller->expects($this->once())
			->method('newTask')
			->with(
				$this->equalTo($record)
			);

		$crudHelper->failedCreate($record, '');
	}

	public function testSuccessfulUpdateInvokesSuccessWhenGivenMessage()
	{
		$controller = $this->mock(['class' => 'SiteController']);
		$notify = $this->mock(['class' => 'Notify', 'methods' => ['success']]);
		$router = $this->mock(['class' => 'App', 'methods' => ['redirect']]);
		$crudHelper = new CrudHelper([
			'controller' => $controller,
			'notify' => $notify,
			'router' => $router
		]);

		$notify->expects($this->once())
			->method('success');

		$crudHelper->successfulUpdate('url', 'not empty');
	}

	public function testSuccessfulUpdateInvokesSuccessWhenMessageEmpty()
	{
		$controller = $this->mock(['class' => 'SiteController']);
		$notify = $this->mock(['class' => 'Notify', 'methods' => ['success']]);
		$router = $this->mock(['class' => 'App', 'methods' => ['redirect']]);
		$crudHelper = new CrudHelper([
			'controller' => $controller,
			'notify' => $notify,
			'router' => $router
		]);

		$notify->expects($this->never())
			->method('success');

		$crudHelper->successfulUpdate('url', '');
	}

	public function testfailedUpdateInvokesSetView()
	{
		$controller = $this->mock([
			'class' => 'SiteController',
			'methods' => ['setView', 'editTask'],
			'props' => ['name' => '']
		]);
		$notify = $this->mock(['class' => 'Notify', 'methods' => ['error']]);
		$record = $this->mock([
			'class' => 'Relational', 'methods' => ['getErrors' => []]
		]);
		$crudHelper = new CrudHelper([
			'controller' => $controller,
			'notify' => $notify
		]);

		$controller->expects($this->once())
			->method('setView')
			->with(
				$this->equalTo(null),
				$this->equalTo('edit')
			);

		$crudHelper->failedUpdate($record);
	}

	public function testfailedUpdateInvokesEditTask()
	{
		$controller = $this->mock([
			'class' => 'SiteController',
			'methods' => ['setView', 'editTask'],
			'props' => ['name' => '']
		]);
		$notify = $this->mock(['class' => 'Notify', 'methods' => ['error']]);
		$record = $this->mock([
			'class' => 'Relational', 'methods' => ['getErrors' => []]
		]);
		$crudHelper = new CrudHelper([
			'controller' => $controller,
			'notify' => $notify
		]);

		$controller->expects($this->once())
			->method('editTask')
			->with($this->equalTo($record));

		$crudHelper->failedUpdate($record);
	}

}
