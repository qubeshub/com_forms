<?php
/*
 * @package   hubzero-cms
 * @copyright Copyright 2005-2015 HUBzero Foundation, LLC.
 * @license   http://opensource.org/licenses/MIT MIT
 */

// No direct access
defined('_HZEXEC_') or die();

$action = $this->createCommentUrl;
$comment = $this->comment;
$feedItems = $this->feedItems;
$formId = $this->formId;
$responseId = $this->responseId;
$submitInputValue = Lang::txt('COM_FORMS_FIELDS_VALUES_COMMENT');
?>

<div class="response-feed">

	<div class="response-feed-comments">
		<?php
			foreach ($feedItems as $item):
				$this->view('_response_feed_item')
					->set('item', $item)
					->display();
			endforeach;

			if ($feedItems->count() == 0):
				$this->view('_response_feed_empty_notice')
				->display();
			endif;
		?>
	</div>

	<div class="response-feed-form">
		<form action="<?php echo $action; ?>">
			<textarea name="comment" cols="30" rows="5"><?php echo $comment; ?></textarea>

			<input type="hidden" name="form_id" value="<?php echo $formId; ?>" />
			<input type="hidden" name="response_id" value="<?php echo $responseId; ?>" />

			<input type="submit" class="btn btn-success"
				value="<?php echo $submitInputValue; ?>" />
		</form>
	</div>

</div>
