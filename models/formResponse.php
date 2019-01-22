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

class FormResponse extends Relational
{

	/**
	 * Records table
	 *
	 * @var string
	 */
	protected $table = '#__forms_form_responses';

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

}