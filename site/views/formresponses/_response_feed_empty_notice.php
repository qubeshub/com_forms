<?php
/*
 * @package   hubzero-cms
 * @copyright Copyright 2005-2015 HUBzero Foundation, LLC.
 * @license   http://opensource.org/licenses/MIT MIT
 */

// No direct access
defined('_HZEXEC_') or die();

$feedEmptyNotice = Lang::txt('This response\'s feed is empty right now.');

?>

<div class="empty-feed-notice">
	<?php echo $feedEmptyNotice; ?>
</div>
