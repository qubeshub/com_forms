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

$componentPath = Component::path('com_forms');

require_once "$componentPath/helpers/apiBatchUpdateResponse.php";
require_once "$componentPath/helpers/apiNullResponse.php";
require_once "$componentPath/helpers/apiReadResponse.php";

use Components\Forms\Helpers\ApiBatchUpdateResponse;
use Components\Forms\Helpers\ApiNullResponse;
use Components\Forms\Helpers\ApiReadResponse;

class ApiResponseFactory
{

	/**
	 * Instantiates appropriate ApiResponse type
	 *
	 * @param    array    $args   CRUD operation and result
	 * @return   object
	 *
	 */
	public function one($args)
	{
		$operation = $args['operation'];

		switch($operation)
		{
			case 'batchUpdate':
				return new ApiBatchUpdateResponse($args);
			case 'read':
				return new ApiReadResponse($args);
			default:
				return new ApiNullResponse($args);
		}
	}

}