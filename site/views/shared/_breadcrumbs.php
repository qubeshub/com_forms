<?php
/*
 * @package   hubzero-cms
 * @copyright Copyright 2005-2015 HUBzero Foundation, LLC.
 * @license   http://opensource.org/licenses/MIT MIT
 */

// No direct access
defined('_HZEXEC_') or die();

$breadcrumbs = $this->breadcrumbs;
$page = $this->page;

foreach ($breadcrumbs as $text => $url)
{
	Pathway::append($text, $url);
}

Document::setTitle($page);

