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

$componentPath = Component::path('com_forms');

require_once "$componentPath/models/formPage.php";
require_once "$componentPath/models/formPrerequisite.php";
require_once "$componentPath/models/formResponse.php";
require_once "$componentPath/models/pageField.php";

use Components\Forms\Models\FormResponse;
use Components\Forms\Models\PageField;
use Hubzero\Database\Relational;

class Form extends Relational
{

	static protected $_pageClass = 'Components\Forms\Models\FormPage';
	static protected $_prerequisiteClass = 'Components\Forms\Models\FormPrerequisite';

	protected $table = '#__forms_forms';

	/*
	 * Attributes to be populated on record creation
	 *
	 * @var array
	 */
	public $initiate = ['created'];

	/*
	 * Attribute validation
	 *
	 * @var  array
	 */
	public $rules = [
		'name' => 'notempty',
		'opening_time' => 'notempty',
		'closing_time' => 'notempty'
	];

	/**
	 * Determines if users responses to prereqs were accepted
	 *
	 * @param    int    $userId   User's ID
	 * @return   object
	 */
	public function prereqsAccepted($userId)
	{
		$prereqs = $this->getPrerequisites()
			->rows();
		$prereqsAccepted = true;

		foreach ($prereqs as $prereq)
		{
			if (!$prereq->acceptedFor($userId))
			{
				$prereqsAccepted = false;
				break;
			}
		}

		return $prereqsAccepted;
	}

	/**
	 * Returns associated prerequisites
	 *
	 * @return   object
	 */
	public function getPrerequisites()
	{
		$prerequisiteModelClass = self::$_prerequisiteClass;
		$foreignKey = 'form_id';

		$prerequisites = $this->oneToMany($prerequisiteModelClass, $foreignKey);

		return $prerequisites;
	}

	/**
	 * Indicates if given user response was accepted
	 *
	 * @param    int    $userId   User's ID
	 * @return   bool
	 */
	public function acceptedFor($userId)
	{
		$response = $this->getResponse($userId);

		return !!$response->get('accepted');
	}

	/**
	 * Returns associated responses
	 *
	 * @param    int      $userId Given user's ID
	 * @return   object
	 */
	public function getResponse($userId)
	{
		$response = self::_getResponse($this->get('id'), $userId);

		return $response;
	}

	/**
	 * Searches for response with given form and user IDs
	 *
	 * @param    int      $formId   Given form's ID
	 * @param    int      $userId   Given user's ID
	 * @return   object
	 */
	protected static function _getResponse($formId, $userId)
	{
		$responseClass = self::_getResponseClass();

		$response = $responseClass::oneWhere([
			'form_id' => $formId,
			'user_id' => $userId
		]);

		return $response;
	}

	/**
	 * Returns form response model class
	 *
	 * @return   object
	 */
	protected static function _getResponseClass()
	{
		return get_class(FormResponse::blank());
	}

	/**
	 * Get associated fields
	 *
	 * @return   object
	 */
	public function getFields()
	{
		$pagesIds = $this->_getPagesIds();
		$fieldClass = self::_getFieldClass();

		$fields = $fieldClass::all()
			->whereIn('page_id', $pagesIds);

		return $fields;
	}

	/**
	 * Returns associated pages IDs
	 *
	 * @return   array
	 */
	protected function _getPagesIds()
	{
		$pages = $this->getPages()->select('id')->execute();

		$pagesIds = array_map(function($page) {
			return $page->id;
		}, $pages);

		return $pagesIds;
	}

	/**
	 * Returns field class
	 *
	 * @return   object
	 */
	protected static function _getFieldClass()
	{
		$fieldClass = get_class(PageField::blank());

		return $fieldClass;
	}

	/**
	 * Get associated pages
	 *
	 * @return   object
	 */
	public function getPages()
	{
		$pageModelClass = self::$_pageClass;
		$foreignKey = 'form_id';

		$pages = $this->oneToMany($pageModelClass, $foreignKey);

		return $pages;
	}

	/**
	 * Retrieves page at given location
	 *
	 * @param    int      $position   Ordinal position
	 * @return   object
	 */
	public function getPageOrdinal($position)
	{
		$pages = $this->getPages()
			->order('order', 'asc')
			->rows()
			->raw();

		$pageArray = array_slice($pages, $position - 1, 1);
		$page = $pageArray[0];

		return $page;
	}

}
