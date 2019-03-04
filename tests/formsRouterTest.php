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

	public function testFormsNewUrlReturnsCorrectUrl()
	{
		$routes = new FormsRouter();
		$expectedUrl = '/forms/forms/new';

		$generatedUrl = $routes->formsNewUrl();

		$this->assertEquals($expectedUrl, $generatedUrl);
	}

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

		$generatedUrl = $routes->formsDisplayUrl($testId);

		$this->assertEquals($expectedUrl, $generatedUrl);
	}

	public function testFormsPagesUrlReturnsCorrectUrl()
	{
		$routes = new FormsRouter();
		$testId = 99;
		$expectedUrl = "/forms/pages?form_id=$testId";

		$generatedUrl = $routes->formsPagesUrl($testId);

		$this->assertEquals($expectedUrl, $generatedUrl);
	}

	public function testFormsPagesNewUrlReturnsCorrectUrl()
	{
		$routes = new FormsRouter();
		$testId = 99;
		$expectedUrl = "/forms/pages/new?form_id=$testId";

		$generatedUrl = $routes->formsPagesNewUrl($testId);

		$this->assertEquals($expectedUrl, $generatedUrl);
	}

	public function testFormsPagesCreateUrlReturnsCorrectUrl()
	{
		$routes = new FormsRouter();
		$testId = 99;
		$expectedUrl = "/forms/pages/create?form_id=$testId";

		$generatedUrl = $routes->formsPagesCreateUrl($testId);

		$this->assertEquals($expectedUrl, $generatedUrl);
	}

	public function testPagesEditUrlReturnsCorrectUrl()
	{
		$routes = new FormsRouter();
		$testId = 99;
		$expectedUrl = "/forms/pages/$testId/edit";

		$generatedUrl = $routes->pagesEditUrl($testId);

		$this->assertEquals($expectedUrl, $generatedUrl);
	}

	public function testPagesUpdateUrlReturnsCorrectUrl()
	{
		$routes = new FormsRouter();
		$testId = 99;
		$expectedUrl = "/forms/pages/$testId/update";

		$generatedUrl = $routes->pagesUpdateUrl($testId);

		$this->assertEquals($expectedUrl, $generatedUrl);
	}

	public function testPagesFieldsEditUrlReturnsCorrectUrl()
	{
		$routes = new FormsRouter();
		$testId = 99;
		$expectedUrl = "/forms/fields?page_id=$testId";

		$generatedUrl = $routes->pagesFieldsEditUrl($testId);

		$this->assertEquals($expectedUrl, $generatedUrl);
	}

	public function testFormResponseStartUrlReturnsCorrectUrl()
	{
		$routes = new FormsRouter();
		$testId = 99;
		$expectedUrl = "/forms/responses/start?form_id=$testId";

		$generatedUrl = $routes->formResponseStartUrl($testId);

		$this->assertEquals($expectedUrl, $generatedUrl);
	}

	public function testFormsPageResponseUrlReturnsCorrectUrl()
	{
		$routes = new FormsRouter();
		$queryParams = ['form_id' => 99, 'page' => 1];
		$expectedUrl = '/forms/fill?form_id=99&page=1';

		$generatedUrl = $routes->formsPageResponseUrl($queryParams);

		$this->assertEquals($expectedUrl, $generatedUrl);
	}

	public function testFormsPrereqsUrlReturnsCorrectUrl()
	{
		$routes = new FormsRouter();
		$id = 99;
		$expectedUrl = "/forms/steps?form_id=$id";

		$generatedUrl = $routes->formsPrereqsUrl($id);

		$this->assertEquals($expectedUrl, $generatedUrl);
	}

	public function testPrereqsEditUrlReturnsCorrectUrl()
	{
		$routes = new FormsRouter();
		$id = 99;
		$expectedUrl = "/forms/steps/$id/edit";

		$generatedUrl = $routes->prereqsEditUrl($id);

		$this->assertEquals($expectedUrl, $generatedUrl);
	}

	public function testPrereqsNewUrlReturnsCorrectUrl()
	{
		$routes = new FormsRouter();
		$id = 99;
		$expectedUrl = "/forms/steps/new?form_id=$id";

		$generatedUrl = $routes->formsPrereqsNewUrl($id);

		$this->assertEquals($expectedUrl, $generatedUrl);
	}

	public function testPrereqsUpdateUrlReturnsCorrectUrl()
	{
		$routes = new FormsRouter();
		$id = 99;
		$expectedUrl = "/forms/steps/update?form_id=$id";

		$generatedUrl = $routes->prereqsUpdateUrl($id);

		$this->assertEquals($expectedUrl, $generatedUrl);
	}

	public function testPrereqsCreateUrlReturnsCorrectUrl()
	{
		$routes = new FormsRouter();
		$expectedUrl = "/forms/steps/create";

		$generatedUrl = $routes->prereqsCreateUrl();

		$this->assertEquals($expectedUrl, $generatedUrl);
	}

	public function testBatchPagesUpdateUrlReturnsCorrectUrl()
	{
		$routes = new FormsRouter();
		$expectedUrl = "/forms/pages/batchupdate";

		$generatedUrl = $routes->batchPagesUpdateUrl();

		$this->assertEquals($expectedUrl, $generatedUrl);
	}

	public function testFieldsResponsesCreateUrlReturnsCorrectUrl()
	{
		$routes = new FormsRouter();
		$expectedUrl = "/forms/fill/create";

		$generatedUrl = $routes->fieldsResponsesCreateUrl();

		$this->assertEquals($expectedUrl, $generatedUrl);
	}

	public function testFormResponseReviewReturnsCorrectUrl()
	{
		$expectedUrl = '/forms/responses/review?form_id=1';
		$formId = 1;
		$routes = new FormsRouter();

		$generatedUrl = $routes->formResponseReviewUrl($formId);

		$this->assertEquals($expectedUrl, $generatedUrl);
	}

	public function testFormResponseSubmitReturnsCorrectUrl()
	{
		$expectedUrl = '/forms/responses/submit';
		$routes = new FormsRouter();

		$generatedUrl = $routes->formResponseSubmitUrl();

		$this->assertEquals($expectedUrl, $generatedUrl);
	}

	public function testFormResponseListReturnsCorrectUrl()
	{
		$formId = 976;
		$expectedUrl = "/forms/admin/responses?form_id=$formId";
		$routes = new FormsRouter();

		$generatedUrl = $routes->formsResponseList($formId);

		$this->assertEquals($expectedUrl, $generatedUrl);
	}

	public function testUserProfileUrlReturnsCorrectUrl()
	{
		$userId = 91;
		$expectedUrl = "/members/$userId";
		$routes = new FormsRouter();

		$generatedUrl = $routes->userProfileUrl($userId);

		$this->assertEquals($expectedUrl, $generatedUrl);
	}

	public function testAdminResponseReviewUrlReturnsCorrectUrl()
	{
		$responseId = 1;
		$expectedUrl = "/forms/admin/response?response_id=$responseId";
		$routes = new FormsRouter();

		$generatedUrl = $routes->adminResponseReviewUrl($responseId);

		$this->assertEquals($expectedUrl, $generatedUrl);
	}

}
