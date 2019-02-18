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

class FieldResponse extends Relational
{

	protected $table = '#__forms_fields_responses';
	protected static $_fieldModelName = 'Components\Forms\Models\PageField';
	protected static $_responseModelName = 'Components\Forms\Models\FormResponse';

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
		'form_response_id' => 'notempty',
		'field_id' => 'notempty'
	];

	/**
	 * Returns associated form response ID
	 *
	 * @return   int
	 */
	public function getFormResponseId()
	{
		$formResponse = $this->getFormResponse();

		return $formResponse->get('id');
	}

	/**
	 * Returns associated form response
	 *
	 * @return   object
	 */
	public function getFormResponse()
	{
		if ($this->isNew())
		{
			$formResponse = $this->_lookupFormResponse();
		}
		else
		{
			$formResponse = $this->_getFormResponseByAssociation();
		}

		return $formResponse;
	}

	/**
	 * Returns associated form response based on user_id & form_id
	 *
	 * @return   object
	 */
	protected function _lookupFormResponse()
	{
		$userId = $this->get('user_id');
		$formId = $this->_getFormId();

		$formResponse = self::_formResponseFor($formId, $userId);

		return $formResponse;
	}

	/**
	 * Returns FormResponse for given form and user
	 *
	 * @return   object
	 */
	protected static function _formResponseFor($formId, $userId)
	{
		$formResponsesHelper = self::_getFormResponsesHelper();

		$formResponse = $formResponsesHelper::all()
			->whereEquals('form_id', $formId)
			->whereEquals('user_id', $userId)
			->row();

		return $formResponse;
	}

	protected static function _getFormResponsesHelper()
	{
		return self::$_responseModelName;
	}

	/**
	 * Returns field's form's ID
	 *
	 * @return   int
	 */
	protected function _getFormId()
	{
		$field = $this->getField();

		return $field->getFormId();
	}

	/**
	 * Returns associated field by association
	 *
	 * @return   object
	 */
	public function getField()
	{
		$fieldModelName = self::$_fieldModelName;
		$foreignKey = 'field_id';

		$field = $this->belongsToOne($fieldModelName, $foreignKey)
			->row();

		return $field;
	}

	/**
	 * Returns associated form response by association
	 *
	 * @return   object
	 */
	protected function _getFormResponseByAssociation()
	{
		$responseModelName = self::$_responseModelName;
		$foreignKey = 'form_response_id';

		$formResponse = $this->belongsToOne($responseModelName, $foreignKey)
			->row();

		return $formResponse;
	}

}
