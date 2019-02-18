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

namespace Components\Forms\Models;

use Hubzero\Database\Relational;

class PageField extends Relational
{

	static protected $_responseClass = 'Components\Forms\Models\FieldResponse';
	static protected $_pageModelName = 'Components\Forms\Models\FormPage';

	/**
	 * Records table
	 *
	 * @var string
	 */
	protected $table = '#__forms_page_fields';

	/**
	 * Attributes to be populated on record creation
	 *
	 * @var array
	 */
	public $initiate = ['created'];

	/**
	 * Attribute validation
	 *
	 * @var  array
	 */
	public $rules = [
		'page_id' => 'positive',
		'order' => 'positive',
		'type' => 'notempty'
	];

	/**
	 * Returns field's options
	 *
	 * @return   array
	 */
	public function getOptions()
	{
		$options = $this->get('values', []);

		$decodedOptions = json_decode($options);

		return $decodedOptions;
	}

	/**
	 * Returns field response for current user
	 *
	 * @return   object
	 */
	public function getCurrentUsersResponse()
	{
		$currentUserId = self::_getCurrentUsersId();

		$response = $this->getResponse($currentUserId);

		return $response;
	}

	/**
	 * Returns field response for given user
	 *
	 * @param    int      $userId   User's ID
	 * @return   object
	 */
	public function getResponse($userId)
	{
		$responses = $this->getResponses();

		$response = $responses
			->whereEquals('user_id', $userId)
			->rows()
			->current();

		if (!$response)
		{
			$fieldId = $this->get('id');
			$response = self::_nullResponse([
				'field_id' => $fieldId,
				'user_id' => $userId
			]);
		}

		return $response;
	}

	/**
	 * Returns associated field responses
	 *
	 * @return   object
	 */
	public function getResponses()
	{
		$responseModelClass = self::$_responseClass;
		$foreignKey = 'field_id';

		$responses = $this->oneToMany($responseModelClass, $foreignKey);

		return $responses;
	}

	/**
	 * Returns page's form's ID
	 *
	 * @return   int
	 */
	public function getFormId()
	{
		$page = $this->getPage();

		return $page->getFormId();
	}

	/**
	 * Returns associated page
	 *
	 * @return   object
	 */
	public function getPage()
	{
		$pageModelName = self::$_pageModelName;
		$foreignKey = 'page_id';

		$page = $this->belongsToOne($pageModelName, $foreignKey)
			->row();

		return $page;
	}

	/**
	 * Returns current user's ID
	 *
	 * @return   int
	 */
	protected static function _getCurrentUsersId()
	{
		$currentUsersId = User::get('id');

		return $currentUsersId;
	}

	/**
	 * Instantiates null response object for given field
	 *
	 * @param    object   $state   Instantiation state
	 * @return   object
	 */
	protected static function _nullResponse($state)
	{
		$response = FieldResponse::blank();

		$response->set($state);

		return $response;
	}

}
