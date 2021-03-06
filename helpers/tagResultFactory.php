<?php
/**
 * @package    hubzero-cms
 * @copyright  Copyright (c) 2005-2020 The Regents of the University of California.
 * @license    http://opensource.org/licenses/MIT MIT
 */

namespace Components\Forms\Helpers;

$componentPath = Component::path('com_forms');

require_once "$componentPath/helpers/addTagsResult.php";
require_once "$componentPath/helpers/updateTagsResult.php";

use Components\Forms\Helpers\AddTagsResult as AddResult;
use Components\Forms\Helpers\UpdateTagsResult as UpdateResult;

class TagResultFactory
{

	/**
	 * Returns tag add result object
	 *
	 * @return   object
	 */
	public function addResult()
	{
		return new AddResult();
	}

	/**
	 * Returns tag update result object
	 *
	 * @return   object
	 */
	public function updateResult()
	{
		return new UpdateResult();
	}

}
