<?php
/*
 * @package   hubzero-cms
 * @copyright Copyright 2005-2015 HUBzero Foundation, LLC.
 * @license   http://opensource.org/licenses/MIT MIT
 */

namespace Components\Forms\Helpers;

use stdClass;

class AddTagsResult
{

	/**
	 * Constructs AddTagsResult instance
	 *
	 * @return   void
	 */
	public function __construct()
	{
		$this->_failures = [];
		$this->_successes = [];
	}

	/**
	 * Indicates whether tags were added to all records
	 *
	 * @return   bool
	 */
	public function succeeded()
	{
		$tagsAdded = !empty($this->_successes);
		$noFailures = empty($this->_failures);

		return $tagsAdded && $noFailures;
	}

	/**
	 * Adds model and errors to failures
	 *
	 * @param    object   $record   Given record
	 * @param    array    $errors   Tag association errors
	 * @return   void
	 */
	public function addFailure($record, $errors)
	{
		$taggingFailure = new stdClass;

		$taggingFailure->record = $record;
		$taggingFailure->errors = $errors;

		$this->_failures[] = $taggingFailure;
	}

	/**
	 * Returns failures
	 *
	 * @return   array
	 */
	public function getFailures()
	{
		return $this->_failures;
	}

	/**
	 * Adds model to successes
	 *
	 * @param    object   $record   Given record
	 * @return   void
	 */
	public function addSuccess($record)
	{
		$taggingSuccess = new stdClass;

		$taggingSuccess->record = $record;

		$this->_successes[] = $taggingSuccess;
	}

	/**
	 * Returns successes
	 *
	 * @return   array
	 */
	public function getSuccesses()
	{
		return $this->_successes;
	}

	/**
	 * Instantiates AddTagsResult object
	 *
	 * @param    array    $args   Instantiation state
	 * @return   object
	 */
	public static function one($args = [])
	{
		return new self($args);
	}

}
