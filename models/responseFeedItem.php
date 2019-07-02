<?php
/*
 * @package   hubzero-cms
 * @copyright Copyright 2005-2015 HUBzero Foundation, LLC.
 * @license   http://opensource.org/licenses/MIT MIT
 */

namespace Components\Forms\Models;

use Hubzero\Activity\Log;

class ResponseFeedItem extends Log
{

	protected $table = '#__activity_logs';

	/**
	 * Form responses activity scope
	 *
	 * @var   string
	 */
	protected	static $ACTIVITY_SCOPE = 'forms.responses';

	/**
	 * Retrieves all activity items in form response scope
	 *
	 * @return   object
	 */
	public static function all($columns = null)
	{
		return parent::all()
			->whereEquals('scope', self::$ACTIVITY_SCOPE);
	}

	/**
	 * Returns all activity items for response w/ given ID
	 *
	 * @param    int      $responseId   Response record's ID
	 * @return   object
	 */
	public static function allFor($responseId)
	{
		return self::all()
			->whereEquals('scope_id', $responseId);
	}

}
