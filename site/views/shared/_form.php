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
$elements = $this->elements;
$hiddenMetadata = $this->hiddenMetadata;
$noJsNotice = Lang::txt('COM_FORMS_NOTICES_FIELDS_FILL_NO_JS');
$submitClasses = $this->submitClasses;
$submitValue = $this->submitValue;
$title = $this->title;
?>

<form action="<?php echo $action; ?>" method="post" id="hubForm">

	<fieldset>
		<legend><?php echo $title; ?></legend>

		<?php
			foreach($elements as $element):
				$this->view('_form_element', 'shared')
					->set('element', $element)
					->display();
			endforeach;
		?>
	</fieldset>

	<span>
		<?php foreach($hiddenMetadata as $datum): ?>
			<input type="hidden"
				name="<?php echo $datum->name; ?>"
				value="<?php echo $datum->value; ?>">
		<?php	endforeach; ?>
	</span>

	<div class="button-container">
		<input type="submit"
			value="<?php echo $submitValue; ?>"
			class="<?php echo $submitClasses; ?>">
	</div>

</form>

<noscript>
	<h2>
		<?php echo $noJsNotice; ?>
	</h2>
</noscript>
