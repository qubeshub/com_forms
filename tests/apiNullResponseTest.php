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

require_once "$componentPath/helpers/apiNullResponse.php";
require_once "$componentPath/tests/helpers/canMock.php";

use Hubzero\Test\Basic;
use Components\Forms\Helpers\ApiNullResponse;
use Components\Forms\Tests\Traits\canMock;

class ApiNullResponseTest extends Basic
{
	use canMock;

	public function testCanBeInstantiatedWithoutAnyArgs()
	{
		$response = new ApiNullResponse();

		$responseClass = get_class($response);

		$this->assertEquals('Components\Forms\Helpers\ApiNullResponse', $responseClass);
	}

	public function testArrayHasSuccessStatusIfResultSucceeded()
	{
		$result = $this->mock(
			['class' => 'Result', 'methods' => ['succeeded' => true]]
		);
		$response = new ApiNullResponse(['result' => $result]);

		$responseArray = $response->toArray();
		$status = $responseArray['status'];

		$this->assertEquals('success', $status);
	}

	public function testArrayHasSuccessStatusIfStatusSuccess()
	{
		$response = new ApiNullResponse(['status' => 'success']);

		$responseArray = $response->toArray();
		$status = $responseArray['status'];

		$this->assertEquals('success', $status);
	}

	public function testArrayHasErrorStatusIfReadResultFailed()
	{
		$result = $this->mock(
			['class' => 'Result', 'methods' => ['succeeded' => false]]
		);
		$response = new ApiNullResponse(['result' => $result]);

		$responseArray = $response->toArray();
		$status = $responseArray['status'];

		$this->assertEquals('error', $status);
	}

	public function testArrayHasErrorStatusIfNoResultOrStatus()
	{
		$response = new ApiNullResponse();

		$responseArray = $response->toArray();
		$status = $responseArray['status'];

		$this->assertEquals('error', $status);
	}

	public function testArrayHasSuccessMessageIfSucceeded()
	{
		$expectedMessage = 'test';
		$response = new ApiNullResponse([
			'status' => 'success',
			'success_message' => $expectedMessage
		]);

		$responseArray = $response->toArray();
		$actualMessage = $responseArray['message'];

		$this->assertEquals($expectedMessage, $actualMessage);
	}

	public function testArrayHasErrorMessageIfFailed()
	{
		$expectedMessage = 'test';
		$response = new ApiNullResponse(['error_message' => $expectedMessage]);

		$responseArray = $response->toArray();
		$actualMessage = $responseArray['message'];

		$this->assertEquals($expectedMessage, $actualMessage);
	}

}