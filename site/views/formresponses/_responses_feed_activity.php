<?php
/**
 * @package    hubzero-cms
 * @copyright  Copyright (c) 2005-2020 The Regents of the University of California.
 * @license    http://opensource.org/licenses/MIT MIT
 */

// No direct access
defined('_HZEXEC_') or die();

$item = $this->item;
$formName = $item->getFormName();
$responseId = $item->getResponseId();
?>

<div class="feed-item">

	<div>
		<?php
			$this->view('_response_feed_item_user_link')
				->set('item', $item)
				->display();

			$this->view('_response_feed_item_activity_description')
				->set('item', $item)
				->display();

			$this->view('_response_feed_item_date')
				->set('item', $item)
				->display();
		?>
	</div>

	<div class="form-name">
		<?php
			$this->view('_response_feed_item_form_link')
				->set('formName', $formName)
				->set('responseId', $responseId)
				->display();
		?>
	</div>

</div>
