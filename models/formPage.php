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

require_once "$componentPath/models/form.php";
require_once "$componentPath/models/pageField.php";

use Hubzero\Database\Relational;

class FormPage extends Relational
{

	static $FORM_MODEL_NAME = 'Components\Forms\Models\Form';
	static $FIELD_MODEL_NAME = 'Components\Forms\Models\PageField';
	static $FIELD_RESPONSE_MODEL_NAME = 'Components\Forms\Models\FieldResponse';
	static $FORM_RESPONSE_MODEL_NAME = 'Components\Forms\Models\FormResponse';

	/**
	 * Records table
	 *
	 * @var string
	 */
	protected $table = '#__forms_form_pages';

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
		'form_id' => 'positive',
		'order' => 'positive'
	];

	/**
	 * Returns associated page's form's ID
	 *
	 * @return   object
	 */
	public function getFormId()
	{
		$form = $this->getForm();

		return $form->get('id');
	}

	/*
	 * Retrieves associated form record
	 *
	 * @return   object
	 */
	public function getForm()
	{
		$formModelName = self::$FORM_MODEL_NAME;
		$foreignKey = 'form_id';

		$form = $this->belongsToOne($formModelName, $foreignKey)->row();

		return $form;
	}

	/*
	 * Retrieves associated field records
	 *
	 * @return   object
	 */
	public function getFields()
	{
		$fieldModelName = self::$FIELD_MODEL_NAME;
		$foreignKey = 'page_id';

		$fields = $this->oneToMany($fieldModelName, $foreignKey);

		return $fields;
	}

	/**
	 * Returns associated field models in an array
	 *
	 * @return   array
	 */
	public function getFieldsInArray()
	{
		$fieldsArray = [];
		$fields = $this->getFields()->rows();

		foreach ($fields as $field)
		{
			$fieldsArray[] = $field;
		}

		return $fieldsArray;
	}

	/**
	 * Indicates whether user can edit $this page
	 *
	 * @param    object   $user   Given user
	 * @return   array
	 */
	public function editableBy($user)
	{
		$userIsOwner = $this->get('created_by') == $user->get('id');

		$editableBy = $userIsOwner;

		return $editableBy;
	}

	/**
	 * Deletes FormPage and associated PageField records
	 *
	 * @return   boool
	 */
	public function destroy()
	{
		$fields = $this->getFields()->rows();

		$allFieldsDestroyed = $fields->destroyAll();

		if ($allFieldsDestroyed)
		{
			$destroyed = parent::destroy();
		}
		else
		{
			$this->setErrors([Lang::txt('COM_FORMS_PAGES_FAILED_DESTROY_FIELDS_NOT_DESTROYED')]);
			$destroyed = false;
		}

		return $destroyed;
	}

	/**
	 * Returns responses for given user in an array
	 *
	 * @param    int     $userId   Given user's ID
	 * @return   array
	 */
	public function responsesInArray($userId)
	{
		$responses = $this->responsesFor($userId);
		$responsesArray = [];

		foreach ($responses as $response)
		{
			$responsesArray[] = $response;
		}

		return $responsesArray;
	}

	/**
	 * Returns responses for given user
	 *
	 * @param    int      $userId   Given user's ID
	 * @return   object
	 */
	public function responsesFor($userId)
	{
		$fieldResponsesHelper = self::_getFieldResponsesHelper();
		$formResponseId = $this->_getFormResponseId($userId);
		$fieldIds = $this->getFieldIds();

		$responses = $fieldResponsesHelper::all()
			->whereEquals('form_response_id', $formResponseId)
			->whereEquals('user_id', $userId)
			->whereIn('field_id', $fieldIds);

		return $responses;
	}

	/**
	 * Returns ID for the user's form response
	 *
	 * @param    int   $userId   Given user's ID
	 * @return   int
	 */
	protected function _getFormResponseId($userId)
	{
		$formResponse = $this->_getFormResponse($userId);

		$formResponseId = $formResponse->get('id');

		return $formResponseId;
	}

	/**
	 * Returns given user's form response
	 *
	 * @param    int   $userId   Given user's ID
	 * @return   int
	 */
	protected function _getFormResponse($userId)
	{
		$formId = $this->getFormId();
		$formResponsesHelper = self::_getFormResponsesHelper();

		$formResponse = $formResponsesHelper::all()
			->whereEquals('form_id', $formId)
			->whereEquals('user_id', $userId)
			->row();

		return $formResponse;
	}

	/**
	 * Returns IDs of associated fields
	 *
	 * @return   array
	 */
	public function getFieldIds()
	{
		$fields = $this->getFieldsInArray();

		$fieldIds = array_map(function($field) {
			return $field->get('id');
		}, $fields);

		return $fieldIds;
	}

	/**
	 * Indicates if page is last in response sequence
	 *
	 * @return   bool
	 */
	public function isLast()
	{
		$formsPages = $this->_getFormsPages();
		$order = $this->get('order');

		$isLast = !$formsPages
			->where('order', '>', $order)
			->count();

		return $isLast;
	}

	/**
	 * Returns position of $this relative to the number of pages before it
	 *
	 * @return   int
	 */
	public function ordinalPosition()
	{
		$order = $this->get('order');
		$pages = $this->_getFormsPages()
			->order('order', 'asc')
			->rows()
			->fieldsByKey('order');

		$position = array_search($order, $pages) + 1;

		return $position;
	}

	/**
	 * Retrieves all pages associated with parent form
	 *
	 * @return   object
	 */
	protected function _getFormsPages()
	{
		$form = $this->getForm();

		$pages = $form->getPages();

		return $pages;
	}

	/**
	 * Returns name of the FieldResponse class
	 *
	 * @return   string
	 */
	protected static function _getFieldResponsesHelper()
	{
		return self::$FIELD_RESPONSE_MODEL_NAME;
	}

	/**
	 * Returns name of the FormResponse class
	 *
	 * @return   string
	 */
	protected static function _getFormResponsesHelper()
	{
		return self::$FORM_RESPONSE_MODEL_NAME;
	}

}
