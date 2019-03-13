<?php
/*
 * @package   hubzero-cms
 * @copyright Copyright 2005-2015 HUBzero Foundation, LLC.
 * @license   http://opensource.org/licenses/MIT MIT
 */

namespace Components\Forms\Helpers;

use Hubzero\Utility\Arr;

class EventDispatcher
{

	/**
	 * Returns an EventDispatcher instance
	 *
	 * @return   void
	 */
	public function __construct($args = [])
	{
		$this->_dispatcher = Arr::getValue(
			$args, 'dispatcher', new MockProxy(['class' => 'Event'])
		);
		$this->_eventScope = 'forms';
	}

	/**
	 * Triggers the field response update event
	 *
	 * @param    array   $fieldResponses   User field responses
	 * @return   void
	 */
	public function fieldResponsesUpdate($fieldResponses)
	{
		$eventName = $this->_generateEventName('onFieldResponsesUpdate');

		$this->_triggerEvent($eventName, [$fieldResponses]);
	}

	/**
	 * Generates event name
	 *
	 * @param    string   $action   Action taken
	 * @return   string
	 */
	protected function _generateEventName($action)
	{
		$eventName = "$this->_eventScope.$action";

		return $eventName;
	}

	/**
	 * Triggers given event with the given data
	 *
	 * @param    string   $eventName   Name of the event
	 * @param    array    $args        Arguments to the event handler
	 * @return   void
	 */
	protected function _triggerEvent($eventName, $args)
	{
		$this->_dispatcher->trigger($eventName, $args);
	}

}
