<?php
/*
 * @package   hubzero-cms
 * @copyright Copyright 2005-2015 HUBzero Foundation, LLC.
 * @license   http://opensource.org/licenses/MIT MIT
 */

// No direct access
defined('_HZEXEC_') or die();

$date = $this->date;
$format = isset($this->format) ? $this->format : 'F j, Y';

if (!!$date)
{
	$dateString = (new DateTime($date))->format($format);
}
else
{
	$dateString = '';
}

echo $dateString;
