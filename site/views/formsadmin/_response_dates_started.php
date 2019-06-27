<?php
/*
 * @package   hubzero-cms
 * @copyright Copyright 2005-2015 HUBzero Foundation, LLC.
 * @license   http://opensource.org/licenses/MIT MIT
 */

// No direct access
defined('_HZEXEC_') or die();

$startedTitle = Lang::txt('COM_FORMS_HEADINGS_DATES_STARTED');
$startedTime = $this->started;
?>

<div>
	<h3>
		<?php echo $startedTitle; ?>
	</h3>
	<?php echo date('F jS, Y', strtotime($startedTime)); ?>
</div>
