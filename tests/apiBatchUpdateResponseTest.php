<?php
/*
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

require_once "$componentPath/helpers/apiBatchUpdateResponse.php";
require_once "$componentPath/tests/helpers/canMock.php";

use Hubzero\Test\Basic;
use Components\Forms\Helpers\ApiBatchUpdateResponse;
use Components\Forms\Tests\Traits\canMock;

class ApiBatchUpdateResponseTest extends Basic
{
	use canMock;

	public function testArrayHasSuccessStatusIfUpdateResultSucceeded()
	{
		$updateResult = $this->mock([
			'class' => 'UpdateResult', 'methods' => ['succeeded' => true]
		]);
		$response = new ApiBatchUpdateResponse([
			'result' => $updateResult, 'error_message' => '', 'success_message' => ''
		]);

		$responseArray = $response->toArray();
		$status = $responseArray['status'];

		$this->assertEquals('success', $status);
	}

	public function testArrayHasErrorStatusIfUpdateResultDidNotSucceed()
	{
		$updateResult = $this->mock([
			'class' => 'UpdateResult',
			'methods' => [
				'getFailedDestroys' => [],
				'getFailedSaves' => [],
			 	'succeeded' => false]
		]);
		$response = new ApiBatchUpdateResponse([
			'result' => $updateResult, 'error_message' => '', 'success_message' => ''
		]);

		$responseArray = $response->toArray();
		$status = $responseArray['status'];

		$this->assertEquals('error', $status);
	}

	public function testArrayHasSuccessMessageIfUpdateResultSucceeded()
	{
		$updateResult = $this->mock([
			'class' => 'UpdateResult',
			'methods' => ['succeeded' => true]
		]);
		$args = ['result' => $updateResult, 'error_message' => '', 'success_message' => 'success'];
		$response = new ApiBatchUpdateResponse($args);

		$responseArray = $response->toArray();
		$message = $responseArray['message'];

		$this->assertEquals($args['success_message'], $message);
	}

	public function testArrayHasErrorMessageIfUpdateResultDidNotSucceed()
	{
		$updateResult = $this->mock([
			'class' => 'UpdateResult',
			'methods' => [
				'getFailedDestroys' => [],
				'getFailedSaves' => [],
			 	'succeeded' => false]
		]);
		$args = ['result' => $updateResult, 'error_message' => 'error', 'success_message' => ''];
		$response = new ApiBatchUpdateResponse($args);

		$responseArray = $response->toArray();
		$message = $responseArray['message'];

		$this->assertEquals($args['error_message'], $message);
	}

	public function testArrayHasNoModelsIfUpdateResultSucceeded()
	{
		$updateResult = $this->mock([
			'class' => 'UpdateResult',
			'methods' => ['succeeded' => true]
		]);
		$response = new ApiBatchUpdateResponse([
			'result' => $updateResult, 'error_message' => '', 'success_message' => ''
		]);

		$responseArray = $response->toArray();
		$hasModelsKey = array_key_exists('models', $responseArray);

		$this->assertEquals(false, $hasModelsKey);
	}

	public function testArrayHasFailedSavesIfUpdateResultDidNotSucceed()
	{
		$modelA = $this->mock([
			'class' => 'Relational', 'methods' => ['get' => 1, 'getErrors' => []]
		]);
		$modelB = $this->mock([
			'class' => 'Relational', 'methods' => ['get' => 2, 'getErrors' => []]
		]);
		$expectedFailedSaves = [
			['id' => 1, 'errors' => []], ['id' => 2, 'errors' => []]
		];
		$updateResult = $this->mock([
			'class' => 'UpdateResult',
			'methods' => [
				'getFailedDestroys' => [],
			 	'getFailedSaves' => [$modelA, $modelB],
				'succeeded' => false
			]
		]);
		$response = new ApiBatchUpdateResponse([
			'result' => $updateResult, 'error_message' => '', 'success_message' => ''
		]);

		$responseArray = $response->toArray();
		$actualFailedSaves = $responseArray['models']['failed_saves'];

		$this->assertEquals($expectedFailedSaves, $actualFailedSaves);
	}

	public function testArrayHasFailedDestroysIfUpdateResultDidNotSucceed()
	{
		$modelA = $this->mock([
			'class' => 'Relational', 'methods' => ['get' => 1, 'getErrors' => []]
		]);
		$modelB = $this->mock([
			'class' => 'Relational', 'methods' => ['get' => 2, 'getErrors' => []]
		]);
		$expectedFailedDestroys = [
			['id' => 1, 'errors' => []], ['id' => 2, 'errors' => []]
		];
		$updateResult = $this->mock([
			'class' => 'UpdateResult',
			'methods' => [
			 	'getFailedDestroys' => [$modelA, $modelB],
				'getFailedSaves' => [],
				'succeeded' => false
			]
		]);
		$response = new ApiBatchUpdateResponse([
			'result' => $updateResult, 'error_message' => '', 'success_message' => ''
		]);

		$responseArray = $response->toArray();
		$actualFailedDestroys = $responseArray['models']['failed_destroys'];

		$this->assertEquals($expectedFailedDestroys, $actualFailedDestroys);
	}

}
