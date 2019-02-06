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

require_once "$componentPath/helpers/prerequisiteScopeClassMap.php";

use Components\Forms\Helpers\PrerequisiteScopeClassMap;
use Hubzero\Database\Relational;

class FormPrerequisite extends Relational
{

	protected $table = '#__forms_form_prerequisites';

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
		'prerequisite_id' => 'notempty',
		'prerequisite_scope' => 'notempty',
		'order' => 'notempty'
	];

	/**
	 * Constructs FormPrerequisite instance
	 *
	 * @param    array   $args   Instantiation state
	 * @return   void
	 */
	public function __construct($args = [])
	{
		$this->_scopeMap = new PrerequisiteScopeClassMap();
		parent::__construct();
	}

	/**
	 * Indicates if given user response was accepted
	 *
	 * @param    int    $userId   User's ID
	 * @return   bool
	 */
	public function acceptedFor($userId)
	{
		$this->_setPrereq();

		return $this->_prereq->acceptedFor($userId);
	}

	/**
	 * Sets prerequisite model
	 *
	 * @return   void
	 */
	protected function _setPrereq()
	{
		if (!isset($this->_prereq))
		{
			$prereqClass = $this->_getPrereqClass();

			$prereqId = $this->get('prerequisite_id');

			$this->_prereq= $prereqClass::one($prereqId);
		}
	}

	/**
	 * Maps scope to prerequisite's class
	 *
	 * @return   string
	 */
	protected function _getPrereqClass()
	{
		$scope = $this->get('prerequisite_scope');

		$prereqClass = $this->_scopeMap->getClass($scope);

		return $prereqClass;
	}

	/**
	 * Gets attributes from actual prereq
	 *
	 * @param    string  $key      Attribute to get
	 * @param    mixed   $default  Value to return if key non-existent
	 * @return   mixed
	 */
	public function getParent($key, $default = null)
	{
		$this->_setPrereq();

		return $this->_prereq->get($key, $default);
	}

}
