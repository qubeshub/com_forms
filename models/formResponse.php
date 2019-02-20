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

require_once "$componentPath/helpers/relationalQueryHelper.php";
require_once "$componentPath/models/fieldResponse.php";

use Components\Forms\Helpers\RelationalQueryHelper;
use Hubzero\Database\Relational;

class FormResponse extends Relational
{

	static protected $_fieldResponseClass = 'Components\Forms\Models\FieldResponse';
	static protected $_formClass = 'Components\Forms\Models\Form';

	/**
	 * Records table
	 *
	 * @var string
	 */
	protected $table = '#__forms_form_responses';

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
		'form_id' => 'notempty',
		'user_id' => 'notempty'
	];

	/**
	 * Constructs FormResponse instance
	 *
	 * @return   void
	 */
	public function __construct($args = [])
	{
		$this->_relationalHelper = new RelationalQueryHelper();
		parent::__construct();
	}

	/**
	 * Returns record based on given criteria
	 *
	 * @param    array   $criteria   Criteria to match record to
	 * @return   object
	 */
	public static function oneWhere($criteria)
	{
		$record = self::_getRecordWhere($criteria);

		if (!$record)
		{
			$record = self::blank();
		}

		return $record;
	}

	/**
	 * Searches for record using given criteria
	 *
	 * @param    array   $criteria   Criteria to match record to
	 * @return   mixed
	 */
	protected static function _getRecordWhere($criteria)
	{
		$query = self::all();

		foreach ($criteria as $attr => $value)
		{
			$query->whereEquals($attr, $value);
		}

		return $query->rows()->current();
	}

	/**
	 * Calculates percentage of required questions user has responded to
	 *
	 * @return   int
	 */
	public function requiredCompletionPercentage()
	{
		$requiredFields = $this->_getRequiredFields();
		$requiredCount = $requiredFields->count();
		$responsesCount = $this->_getResponsesTo($requiredFields)
			->where('response', '!=', "")
			->count();

		if ($requiredCount > 0)
		{
			$requiredCompletionPercentage = round(($responsesCount / $requiredCount) * 100);
		}
		else
		{
			$requiredCompletionPercentage = 100;
		}

		return $requiredCompletionPercentage;
	}

	/**
	 * Gets forms required fields
	 *
	 * @return   object
	 */
	protected function _getRequiredFields()
	{
		$allFields = $this->_getFields();

		$requiredFields = $allFields->whereEquals('required', 1);

		return $requiredFields;
	}

	/**
	 * Gets all of the forms fields
	 *
	 * @return   object
	 */
	protected function _getFields()
	{
		$form = $this->getForm();

		$fields = $form->getFields();

		return $fields;
	}

	/**
	 * Gets all forms fields
	 *
	 * @return   object
	 */
	public function getForm()
	{
		$formClass = self::$_formClass;

		$form = $this->belongsToOne($formClass, 'form_id')
			->rows();

		return $form;
	}

	/**
	 * Returns user's responses to given fields
	 *
	 * @param    object   $fields   Fields to search for responses to
	 * @return   object
	 */
	protected function _getResponsesTo($fields)
	{
		$fieldsIds = $this->_relationalHelper->flatMap($fields, 'id');

		$specificResponses = $this->getResponses()
			->whereIn('field_id', $fieldsIds);

		return $specificResponses;
	}

	/**
	 * Gets users responses for fields associated with a form
	 *
	 * @return   object
	 */
	public function getResponses()
	{
		$fieldsResponseClass = self::$_fieldResponseClass;
		$foreignKey = 'form_response_id';

		$fieldsResponses = $this->oneToMany($fieldsResponseClass, $foreignKey);

		return $fieldsResponses;
	}

}
