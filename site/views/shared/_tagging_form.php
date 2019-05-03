<?php
/*
 * @package   hubzero-cms
 * @copyright Copyright 2005-2015 HUBzero Foundation, LLC.
 * @license   http://opensource.org/licenses/MIT MIT
 */

// No direct access
defined('_HZEXEC_') or die();

$action = $this->action;
$hiddenFields = isset($this->hiddenFields) ? $this->hiddenFields : [];

$autocompleter = Event::trigger('hubzero.onGetMultiEntry', [[]]);
?>

<form id="hubForm" action="<?php echo $action; ?>">

	<fieldset>

		<?php
			if (count($autocompleter) > 0):
				echo $autocompleter[0];
			endif;
		?>

		<input type="submit" class="btn btn-success"
			value="<?php echo Lang::txt('COM_FORMS_FIELDS_VALUES_TAG_RESPONSES'); ?>">
	</fieldset>

	<span>
		<?php foreach($hiddenFields as $name => $value): ?>
			<input type="hidden"
				name="<?php echo $name; ?>"
				value="<?php echo $value; ?>">
		<?php	endforeach; ?>
	</span>

</form>
