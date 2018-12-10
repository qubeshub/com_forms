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
 * @author    Anthony Fuentes <fuentesa@purdue.edu>
 * @copyright Copyright 2005-2015 HUBzero Foundation, LLC.
 * @license   http://opensource.org/licenses/MIT MIT
 */

namespace Components\Forms\Helpers;

$componentPath = Component::path('com_forms');

require_once "$componentPath/helpers/criterion.php";

use Components\Forms\Helpers\Criterion;
use Hubzero\Session;
use Hubzero\Utility\Arr;

class Query
{

	/*
	 * Default session name for query
	 *
	 * @var   string
	 */
	static $defaultName = 'query';

	/*
	 * Default session namespace for query
	 *
	 * @var   string
	 */
	static $defaultNamespace = 'forms';

	public $name, $namespace;

	protected $_criteria, $_errors, $_session;

	/*
	 * Create a Query instance
	 *
	 * @return   void
	 */
	public function __construct($args = [])
	{
		$this->name = Arr::getValue($args, 'name', static::$defaultName);
		$this->namespace = Arr::getValue($args, 'namespace', static::$defaultNamespace);
		$this->_criteria = [];
		$this->_errors = [];
		$this->_session = Arr::getValue($args, 'session', new MockProxy(['class' => 'Session']));
	}

	/*
	 * Instantiates query based on saved data
	 *
	 * @return   object
	 */
	public static function load($args = [])
	{
		$query = new static($args);

		$savedData = $query->_getSavedData();
		$query->setAssociative($savedData);

		return $query;
	}

	/*
	 * Retrieves saved data from session
	 *
	 * @return   array
	 */
	protected function _getSavedData()
	{
		$namespace = $this->namespace;
		$name = $this->name;

		$savedData = $this->_session->get($name, [], $namespace);

		return $savedData;
	}

	/*
	 * Saves query instance's data
	 *
	 * @return   bool
	 */
	public function save()
	{
		$criteria = $this->_toSimpleArray();

		try {
			$this->_session->set($this->name, $criteria, $this->namespace);
		}
		catch (Exception $e) {
			$this->_addError('COM_FORMS_QUERY_SAVE_ERROR');
		}

		$saved = $this->_isValid();

		return $saved;
	}

	/*
	 * Indicates whether or not query is valid
	 *
	 * @return   bool
	 */
	protected function _isValid()
	{
		$isValid = empty($this->getErrors());

		return $isValid;
	}

	/*
	 * Adds an error to instance's error set
	 *
	 * @param    string   $errorKey   The key that corresponds to the error message
	 * @return   void
	 */
	protected function _addError($errorKey)
	{
		$errorMessage = Lang::txt($errorKey);

		$this->errors[] = $errorMessage;
	}

	/*
	 * Returns instance's errors
	 *
	 * @return   array
	 */
	public function getErrors()
	{
		$errors = $this->_errors;

		return $errors;
	}

	/*
	 * Returns an array containing all data set on query instance
	 *
	 * @return   array
	 */
	public function toArray()
	{
		$thisAsArray = $this->_criteria;

		return $thisAsArray;
	}

	/**
	 *
	 *
	 */
	protected function _toSimpleArray()
	{
		$thisAsSimpleArray = [];

		foreach ($this->_criteria as $criterion)
		{
			$thisAsSimpleArray[$criterion->name] = $criterion->toArray();
		}

		return $thisAsSimpleArray;
	}

	/*
	 * Retrieves value for given key from data
	 *
	 * @param    string   $attribute   Name of attribute
	 * @return   void
	 */
	public function get($attribute)
	{
		$nullCriterion = new Criterion();
		$value = Arr::getValue($this->_criteria, $attribute, $nullCriterion);

		return $value;
	}

	/*
	 * Retrieves value within attribute array from data
	 *
	 * @param    string   $attribute   Name of attribute
	 * @return   void
	 */
	public function getValue($attribute)
	{
		$criterion = Arr::getValue($this->_criteria, $attribute, null);
		$value = null;

		if ($criterion)
		{
			$value = $criterion->value;
		}

		return $value;
	}

	/*
	 * Adds given keys and corresponding values to data
	 *
	 * @param    array   $attributes   Key value pairs
	 * @return   void
	 */
	public function setAssociative($attributes)
	{
		foreach ($attributes as $attribute => $value)
		{
			$this->set($attribute, $value);
		}
	}

	/*
	 * Adds given key & value to data
	 *
	 * @param    string   $attribute   Name of attribute
	 * @param    mixed    $value       Value of attribute
	 * @return   void
	 */
	public function set($attribute, $value)
	{
		$criterion = new Criterion([
			'name' => $attribute,
			'operator' => $value['operator'],
			'value'  => $value['value']
		]);

		$this->_criteria[$attribute] = $criterion;
	}

}
