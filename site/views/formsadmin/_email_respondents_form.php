<?php
/*
 * @package   hubzero-cms
 * @copyright Copyright 2005-2015 HUBzero Foundation, LLC.
 * @license   http://opensource.org/licenses/MIT MIT
 */

// No direct access
defined('_HZEXEC_') or die();

$action = $this->action;
$emailButton = Lang::txt('COM_FORMS_HEADINGS_EMAIL_RESPONDENTS');
$formId = $this->formId;
?>


<?php echo $emailButton; ?>

<form id="email-respondents-form" action="<?php echo $action; ?>">
	<input type="hidden" name="form_id" value="<?php echo $formId; ?>">
</form>
