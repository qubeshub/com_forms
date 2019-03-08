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

class SortableResponses
{

	/**
	 * Constructs SortableResponses instance
	 *
	 * @param    array   $args   Instantiation state
	 * @return   void
	 */
	public function __construct($args)
	{
		$this->_responses = $args['responses'];
		$this->_rows = null;

		$this->pagination = $this->_responses->pagination;
	}

	/**
	 * Orders responses based on given field and direction
	 *
	 * @param    string   $sortField       Field to sort by
	 * @param    string   $sortDirection   Sorting direction
	 * @return   void
	 */
	public function order($sortField, $sortDirection)
	{
		switch ($sortField)
		{
			case 'completion_percentage':
				$this->_orderByCompletionPercentage($sortDirection);
				break;
			default:
				$this->_responses->order($sortField, $sortDirection);
		}
	}

	/**
	 * Orders responses based on calculated completion percentage
	 *
	 * @param    string   $sortDirection   Sorting direction
	 * @return   void
	 */
	protected function _orderByCompletionPercentage($sortDirection)
	{
		$responses = clone $this->_responses;
		$responseRecords = $responses->rows()->raw();

		$directionModifier = ($sortDirection == 'asc') ? 1 : -1;

		usort($responseRecords, function($before, $after) use ($directionModifier) {
			$delta = $before->requiredCompletionPercentage() - $after->requiredCompletionPercentage();
			return $delta * $directionModifier;
		});

		$this->_rows = $responseRecords;
	}

	/**
	 * Returns iterator containing response records
	 *
	 * @return   iterable
	 */
	public function rows()
	{
		$rows = $this->_rows;

		if (!$rows)
		{
			$rows = $this->_responses->rows();
		}

		return $rows;
	}

	/**
	 * Forwards function calls to responses
	 *
	 * @param    string   $name   Function name
	 * @param    array    $args   Function arguments
	 * @return   mixed
	 */
	public function __call($name, $args)
	{
		return $this->_responses->$name(...$args);
	}

}
