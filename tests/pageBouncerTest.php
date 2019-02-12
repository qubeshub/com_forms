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
 * @author    Anthony Fuentes <fuentesa@purdue.edu>
 * @copyright Copyright 2005-2015 HUBzero Foundation, LLC.
 * @license   http://opensource.org/licenses/MIT MIT
 */

namespace Components\Forms\Tests;

$componentPath = Component::path('com_forms');

require_once "$componentPath/helpers/pageBouncer.php";
require_once "$componentPath/tests/helpers/canMock.php";

use Hubzero\Test\Basic;
use Components\Forms\Helpers\PageBouncer;
use Components\Forms\Tests\Traits\canMock;

class PageBouncerTest extends Basic
{
	use canMock;

	public function testRedirectUnlessAuthorizedInvokesAuthorize()
	{
		$permitter = $this->mock([
			'class' => 'FormsAuth', 'methods' => ['currentIsAuthorized']
		]);
		$router = $this->mock(['class' => 'Router', 'methods' => ['redirect']]);
		$bouncer = new PageBouncer([
			'component' => 'com_forms',
			'permitter' => $permitter,
			'router' => $router
		]);

		$permitter->expects($this->once())
			->method('currentIsAuthorized');

		$bouncer->redirectUnlessAuthorized('test');
	}

	public function testRedirectUnlessAuthorizedInvokesRedirect()
	{
		$permitter = $this->mock([
			'class' => 'FormsAuth', 'methods' => ['currentIsAuthorized']
		]);
		$router = $this->mock(['class' => 'Router', 'methods' => ['redirect']]);
		$bouncer = new PageBouncer([
			'component' => 'com_forms',
			'permitter' => $permitter,
			'router' => $router
		]);

		$router->expects($this->once())
			->method('redirect');

		$bouncer->redirectUnlessAuthorized('test');
	}

	public function testRedirectUnlessCanEditFormInvokesCurrentAuthorized()
	{
		$auth = $this->mock([
			'class' => 'FormsAuth',
			'methods' => ['currentIsAuthorized', 'canCurrentUserEditForm']
		]);
		$form = $this->mock(['class' => 'Form']);
		$router = $this->mock(['class' => 'Router', 'methods' => ['redirect']]);
		$bouncer = new PageBouncer([
			'component' => 'com_forms',
			'permitter' => $auth,
			'router' => $router
		]);

		$auth->expects($this->once())
			->method('currentIsAuthorized')
			->with('core.create');

		$bouncer->redirectUnlessCanEditForm($form);
	}

	public function testRedirectUnlessCanEditFormInvokesCanCurrentUserEditForm()
	{
		$auth = $this->mock([
			'class' => 'FormsAuth',
			'methods' => [
				'currentIsAuthorized' => true,
				'canCurrentUserEditForm' => true
			]
		]);
		$form = $this->mock(['class' => 'Form']);
		$router = $this->mock(['class' => 'Router', 'methods' => ['redirect']]);
		$bouncer = new PageBouncer([
			'component' => 'com_forms',
			'permitter' => $auth,
			'router' => $router
		]);

		$auth->expects($this->once())
			->method('canCurrentUserEditForm')
			->with($form);

		$bouncer->redirectUnlessCanEditForm($form);
	}

	public function testRedirectUnlessCanEditFormInvokesRedirectIfUserCantEditForm()
	{
		$auth = $this->mock([
			'class' => 'FormsAuth',
			'methods' => [
				'currentIsAuthorized' => true,
				'canCurrentUserEditForm' => false
			]
		]);
		$form = $this->mock(['class' => 'Form']);
		$router = $this->mock(['class' => 'Router', 'methods' => ['redirect']]);
		$bouncer = new PageBouncer([
			'component' => 'com_forms',
			'permitter' => $auth,
			'router' => $router
		]);

		$router->expects($this->once())
			->method('redirect');

		$bouncer->redirectUnlessCanEditForm($form);
	}

}
