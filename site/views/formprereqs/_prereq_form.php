<?php
/**
 * HUBzero CMS
 *
 * Copyright 2005-2015 HUBzero Foundation, LLC.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * HUBzero is a registered trademark of Purdue University.
 *
 * @package   hubzero-cms
 * @copyright Copyright 2005-2015 HUBzero Foundation, LLC.
 * @license   http://opensource.org/licenses/MIT MIT
 */

// No direct access
defined('_HZEXEC_') or die();

$action = $this->action;
$fieldsetLegend = Lang::txt('COM_FORMS_HEADINGS_STEP_INFO');
$formId = $this->formId;
$forms = $this->forms;
$prereq = $this->prereq;
$prereqOrder = $prereq->get('order');
$scopeId = $prereq->get('prerequisite_id');

$submitValue = $this->submitValue;
$orderLabel = Lang::txt('COM_FORMS_FIELDS_ORDER');
$formLabel = Lang::txt('COM_FORMS_FIELDS_FORM');
?>

<form id="hubForm" class="full" method="post" action="<?php echo $action; ?>">

	<fieldset>
		<legend>
			<?php echo $fieldsetLegend; ?>
		</legend>

		<div class="grid">
			<div class="col span1">
				<label>
					<?php echo $orderLabel; ?>
					<input name="prereq[order]" type="number" min="0" value="<?php echo $prereqOrder; ?>">
				</label>
			</div>

			<div class="col span11 omega">
				<label>
					<?php
						echo $formLabel;
						$this->view('_form_select')
							->set('forms', $forms)
							->set('scopeId', $scopeId)
							->display();
					?>
				</label>
			</div>
		</div>
	</fieldset>

	<div class="row button-container">
		<input type="hidden" name="prereq[form_id]" value="<?php echo $formId; ?>">
		<input type="hidden" name="prereq[prerequisite_scope]" value="forms_forms">
		<input type="submit" class="btn btn-success" value="<?php echo $submitValue; ?>">
	</div>

</form>

