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

require_once "$componentPath/helpers/comFormsPageBouncer.php";
require_once "$componentPath/helpers/formsRouter.php";
require_once "$componentPath/tests/helpers/canMock.php";

use Hubzero\Test\Basic;
use Components\Forms\Helpers\ComFormsPageBouncer;
use Components\Forms\Helpers\FormsRouter;
use Components\Forms\Tests\Traits\canMock;

class ComFormsPageBouncerTest extends Basic
{
	use canMock;

	public function testRedirectIfPrereqsIncompleteRedirectsToCorrectDefaultUrl()
	{
		$id = 4;
		$form = $this->mock([
			'class' => 'Form',
		 	'methods' => ['get' => $id, 'prereqsAccepted' => false]
		]);
		$notify = $this->mock([
			'class' => 'Notify', 'methods' => ['warning']]
		);
		$router = $this->mock([
			'class' => 'Router', 'methods' => ['redirect']]
		);
		$user = $this->mock([
			'class' => 'User', 'methods' => ['get']]
		);
		$bouncer = new ComFormsPageBouncer([
			'notify' => $notify, 'router' => $router, 'user' => $user
		]);
		$correctUrl = (new FormsRouter)->formsDisplayUrl($id);

		$router->expects($this->once())
			->method('redirect')
			->with($correctUrl);

		$bouncer->redirectIfPrereqsNotAccepted($form);
	}

	public function testRedirectIfPrereqsIncompleteDisplaysCorrectMessage()
	{
		$form = $this->mock([
			'class' => 'Form', 'methods' => ['get', 'prereqsAccepted' => false]
		]);
		$notify = $this->mock([
			'class' => 'Notify', 'methods' => ['warning']]
		);
		$router = $this->mock([
			'class' => 'Router', 'methods' => ['redirect']]
		);
		$user = $this->mock([
			'class' => 'User', 'methods' => ['get']]
		);
		$bouncer = new ComFormsPageBouncer([
			'notify' => $notify, 'router' => $router, 'user' => $user
		]);
		$correctMessage = Lang::txt('COM_FORMS_NOTICES_FORMS_PREREQS_INCOMPLETE');

		$notify->expects($this->once())
			->method('warning')
			->with($correctMessage);

		$bouncer->redirectIfPrereqsNotAccepted($form);
	}

}
