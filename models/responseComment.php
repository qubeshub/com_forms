<?php
/*
 * @package   hubzero-cms
 * @copyright Copyright 2005-2015 HUBzero Foundation, LLC.
 * @license   http://opensource.org/licenses/MIT MIT
 */

namespace Components\Forms\Models;

use Hubzero\Activity\Log;

class ResponseComment extends Log
{

	protected $table = '#__activity_logs';

	/**
	 * Validation rules
	 *
	 * @var   array
	 */
	protected $rules = ['description' => 'notempty'];

	/**
	 * Constructs ResponseComment instance
	 *
	 * @param    array   $args   Instantiation state
	 * @return   void
	 */
	public function __construct($args = [])
	{
		$state = [];

		$state['created'] = Date::toSql();
		$state['created_by'] = User::get('id');
		$state['description'] = $args['content'];
		$state['action'] = 'comment';
		$state['scope'] = 'forms.responses';
		$state['scope_id'] = $args['response_id'];

		$this->set($state);

		parent::__construct();
	}

}
