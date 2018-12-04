<?php
/*
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

$fieldsetLegend = Lang::txt('COM_FORMS_FIELDSET_DATES_OPTIONS');

$form = $this->form;
$formArchived = $form->get('archived');
$formClosingTime = $form->get('closing_time');
$formattedClosingTime = $formClosingTime ? (new DateTime($formClosingTime))
	->format('Y-m-d\TH:i:s') : '';
$formDisabled = $form->get('disabled');
$formOpeningTime = $form->get('opening_time');
$formattedOpeningTime = $formOpeningTime ? (new DateTime($formOpeningTime))
	->format('Y-m-d\TH:i:s') : '';
$formResponsesLocked = $form->get('responses_locked');

$archivedLabel = Lang::txt('COM_FORMS_FIELDS_ARCHIVED');
$closingDateLabel = Lang::txt('COM_FORMS_FIELDS_CLOSING_DATE');
$disabledLabel = Lang::txt('COM_FORMS_FIELDS_DISABLED');
$openingDateLabel = Lang::txt('COM_FORMS_FIELDS_OPENING_DATE');
$responsesLabel = Lang::txt('COM_FORMS_FIELDS_RESPONSES');
?>

<fieldset>

	<legend>
		<?php echo $fieldsetLegend; ?>
	</legend>

	<div class="grid">
		<div class="col span2">
			<label>
				<?php echo $openingDateLabel; ?>
				<div class="datetime-container">
					<input name="form[opening_time]" type="datetime-local"
						value="<?php echo $formattedOpeningTime; ?>">
				</div>
			</label>
		</div>

		<div class="col span2">
			<label>
				<?php echo $closingDateLabel; ?>
				<div class="datetime-container">
					<input name="form[closing_time]" type="datetime-local"
						value="<?php echo $formattedClosingTime; ?>">
				</div>
			</label>
		</div>

		<div class="col span2 offset1">
			<label>
				<?php echo $responsesLabel; ?>
				<div class="radios-container">
					<?php
						$this->view('_binary_inline_radio_list', 'shared')
							->set('falseTextKey', 'COM_FORMS_FIELDS_RESPONSES_EDITABLE')
							->set('flag', $formResponsesLocked)
							->set('name', 'form[responses_locked]')
							->set('trueTextKey', 'COM_FORMS_FIELDS_RESPONSES_LOCKED')
							->display();
					?>
				</div>
			</label>
		</div>

		<div class="col span2">
			<label>
				<?php echo $disabledLabel; ?>
				<div class="radios-container">
					<?php
						$this->view('_binary_inline_radio_list', 'shared')
							->set('flag', $formDisabled)
							->set('name', 'form[disabled]')
							->display();
					?>
				</div>
			</label>
		</div>

		<div class="col span2">
			<label>
				<?php echo $archivedLabel; ?>
				<div class="radios-container">
					<?php
						$this->view('_binary_inline_radio_list', 'shared')
							->set('flag', $formArchived)
							->set('name', 'form[archived]')
							->display();
					?>
				</div>
			</label>
		</div>
	</div>

</fieldset>
