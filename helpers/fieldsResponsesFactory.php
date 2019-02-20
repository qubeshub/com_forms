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

namespace Components\Forms\Helpers;

$compnentPath = Component::path('com_forms');

require_once "$componentPath/helpers/factory.php";

use Components\Forms\Helpers\Factory;

class FieldsResponsesFactory extends Factory
{

	/**
	 * Constructs FieldsResponsesFactory instance
	 *
	 * @param    array   $args   Instantiation state
	 * @return   void
	 */
	public function __construct($args = [])
	{
		$args['model_name'] = 'Components\Forms\Models\FieldResponse';

		parent::__construct($args);
	}

	/**
	 * Updates fields' responses
	 *
	 * @param    array    $submittedResponsesData   Submitted responses data
	 * @return   object
	 */
	public function updateFieldsResponses($currentResponses, $submittedResponsesData)
	{
    $parsedData = $this->_parseResponsesData($submittedResponsesData);

		return parent::batchUpdate($currentResponses, $parsedData);
	}

	/**
	 * Parses given responses' data
	 *
	 * @return array
	 */
	protected function _parseResponsesData($responsesData)
	{
		$parsedData = array_map(function($data) {
			return $this->_parseResponseData($data);
		}, $responsesData);

		return $parsedData;
	}

	/**
	 * Parses given response's data
	 *
	 * @return array
	 */
	protected function _parseResponseData($responseData)
	{
		$parsedData = $responseData;
		$parsedData['user_id'] = User::get('id');

		if (!isset($responseData['response']))
		{
			$parsedData['response'] = null;
		}
		else if (is_array($responseData['response']))
		{
			$parsedData['response'] = json_encode($responseData['response']);
		}

		return $parsedData;
	}

}
