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

require_once "$componentPath/helpers/formsRouter.php";

use Hubzero\Test\Basic;
use Components\Forms\Helpers\FormsRouter;

class FormsRouterTest extends Basic
{

	public function testFormsCreateUrlReturnsCorrectUrl()
	{
		$routes = new FormsRouter();
		$expectedUrl = '/forms/forms/create';

		$generatedUrl = $routes->formsCreateUrl();

		$this->assertEquals($expectedUrl, $generatedUrl);
	}

	public function testFormsEditUrlReturnsCorrectUrl()
	{
		$routes = new FormsRouter();
		$testId = 99;
		$expectedUrl = "/forms/forms/$testId/edit";

		$generatedUrl = $routes->formsEditUrl($testId);

		$this->assertEquals($expectedUrl, $generatedUrl);
	}

	public function testFormsUpdateUrlReturnsCorrectUrl()
	{
		$routes = new FormsRouter();
		$testId = 99;
		$expectedUrl = "/forms/forms/$testId/update";

		$generatedUrl = $routes->formsUpdateUrl($testId);

		$this->assertEquals($expectedUrl, $generatedUrl);
	}

	public function testFormListUrlCorrectUrl()
	{
		$routes = new FormsRouter();
		$expectedUrl = '/forms/forms/list';

		$generatedUrl = $routes->formListUrl();

		$this->assertEquals($expectedUrl, $generatedUrl);
	}

	public function testQueryUpdateUrlReturnsCorrectUrl()
	{
		$routes = new FormsRouter();
		$expectedUrl = '/forms/queries/update';

		$generatedUrl = $routes->queryUpdateUrl();

		$this->assertEquals($expectedUrl, $generatedUrl);
	}

	public function testFormDisplayUrlReturnsCorrectUrl()
	{
		$routes = new FormsRouter();
		$testId = 99;
		$expectedUrl = "/forms/forms/$testId/display";

		$generatedUrl = $routes->formDisplayUrl($testId);

		$this->assertEquals($expectedUrl, $generatedUrl);
	}

}