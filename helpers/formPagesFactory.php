<?php
/*
 * @package   hubzero-cms
 * @copyright Copyright 2005-2015 HUBzero Foundation, LLC.
 * @license   http://opensource.org/licenses/MIT MIT
 */

namespace Components\Forms\Helpers;

$compnentPath = Component::path('com_forms');

require_once "$componentPath/helpers/factory.php";

use Components\Forms\Helpers\Factory;

class FormPagesFactory extends Factory
{

	protected $_modelName;

	/**
	 * Constructs FormPrereqsFactory instance
	 *
	 * @param    array   $args   Instantiation state
	 * @return   void
	 */
	public function __construct($args = [])
	{
		$args['model_name'] = 'Components\Forms\Models\FormPage';

		parent::__construct($args);
	}

	/**
	 * Updates form's associated prerequisites
	 *
	 * @param    object   $currentPages        Form's current pages
	 * @param    array    $submittedPageData   Submitted pages' data
	 * @return   object
	 */
	public function updateFormsPages($currentPages, $submittedPageData)
	{
		return parent::batchUpdate($currentPages, $submittedPageData);
	}

}


