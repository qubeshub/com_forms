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

}
