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

require_once "$componentPath/helpers/crudHelper.php";

use Hubzero\Test\Basic;
use Components\Forms\Helpers\CrudHelper;

class CrudHelperTest extends Basic
{

	public function testSuccessfulCreateInvokesSuccess()
	{
		$controller = $this->getMockBuilder('SiteController')->getMock();
		$notify = $this->getMockBuilder('NotifyWrapper')
			->setMethods(['success'])
			->getMock();
		$router = $this->getMockBuilder('AppWrapper')
			->setMethods(['redirect'])
			->getMock();
		$crudHelper = new CrudHelper([
			'controller' => $controller,
			'notify' => $notify,
			'router' => $router
		]);

		$notify->expects($this->once())
			->method('success');

		$crudHelper->successfulCreate('message', 'url');
	}

	public function testSuccessfulCreateInvokesRedirect()
	{
		$url = 'url';
		$controller = $this->getMockBuilder('SiteController')->getMock();
		$notify = $this->getMockBuilder('NotifyWrapper')
			->setMethods(['success'])
			->getMock();
		$router = $this->getMockBuilder('AppWrapper')
			->setMethods(['redirect'])
			->getMock();
		$crudHelper = new CrudHelper([
			'controller' => $controller,
			'notify' => $notify,
			'router' => $router
		]);

		$router->expects($this->once())
			->method('redirect')
			->with($this->equalTo($url));

		$crudHelper->successfulCreate('message', $url);
	}

	public function testFailedCreateInvokesGetErrors()
	{
		$controller = $this->getMockBuilder('SiteController')
			->setMethods(['setView', 'newTask'])
			->getMock();
		$notify = $this->getMockBuilder('NotifyWrapper')
			->setMethods(['error'])
			->getMock();
		$record = $this->getMockBuilder('Relational')
			->setMethods(['getErrors'])
			->getMock();
		$record->method('getErrors')->willReturn(['']);
		$crudHelper = new CrudHelper([
			'controller' => $controller,
			'notify' => $notify
		]);

		$record->expects($this->once())
			->method('getErrors');

		$crudHelper->failedCreate($record, '');
	}

	public function testFailedCreateInvokesError()
	{
		$controller = $this->getMockBuilder('SiteController')
			->setMethods(['setView', 'newTask'])
			->getMock();
		$notify = $this->getMockBuilder('NotifyWrapper')
			->setMethods(['error'])
			->getMock();
		$record = $this->getMockBuilder('Relational')
			->setMethods(['getErrors'])
			->getMock();
		$record->method('getErrors')->willReturn([]);
		$crudHelper = new CrudHelper([
			'controller' => $controller,
			'notify' => $notify
		]);

		$notify->expects($this->once())
			->method('error');

		$crudHelper->failedCreate($record, '');
	}

	public function testFailedCreateInvokesSetView()
	{
		$controller = $this->getMockBuilder('SiteController')
			->setMethods(['setView', 'newTask'])
			->getMock();
		$notify = $this->getMockBuilder('Notify')
			->setMethods(['error'])
			->getMock();
		$record = $this->getMockBuilder('Relational')
			->setMethods(['getErrors'])
			->getMock();
		$record->method('getErrors')->willReturn([]);
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
		$controller = $this->getMockBuilder('SiteController')
			->setMethods(['setView', 'newTask'])
			->getMock();
		$notify = $this->getMockBuilder('Notify')
			->setMethods(['error'])
			->getMock();
		$record = $this->getMockBuilder('Relational')
			->setMethods(['getErrors'])
			->getMock();
		$record->method('getErrors')->willReturn([]);
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

}
