<?php
/*
 * @package   hubzero-cms
 * @copyright Copyright 2005-2015 HUBzero Foundation, LLC.
 * @license   http://opensource.org/licenses/MIT MIT
 */

// No direct access
defined('_HZEXEC_') or die();

$this->css('formEditNav');

$componentPath = Component::path('com_forms');

require_once "$componentPath/helpers/formsRouter.php";

use Components\Forms\Helpers\FormsRouter as Routes;

$current = $this->current;
$responseId = $this->responseId;
$routes = new Routes();

$steps = [
	'Feed' => $routes->responseFeedUrl($responseId),
	'Responses' => $routes->userFieldResponsesUrl($responseId)
];

$this->view('_ul_nav', 'shared')
	->set('current', $current)
	->set('steps', $steps)
	->display();

