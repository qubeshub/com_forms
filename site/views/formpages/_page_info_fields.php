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

$this->css('formPagesNew');

$page = $this->page;
$pageOrder = $page->get('order');
$pageTitle = $page->get('title');

$fieldsetLegend = Lang::txt('COM_FORMS_FIELDSET_PAGE_INFO');
$orderLabel = Lang::txt('COM_FORMS_FIELDS_ORDER');
$titleLabel = Lang::txt('COM_FORMS_FIELDS_TITLE');
?>

<fieldset>

	<legend>
		<?php echo $fieldsetLegend; ?>
	</legend>

	<div class="grid">
		<div class="col span1">
			<label>
				<?php echo $orderLabel; ?>
				<input name="page[order]" type="number" min="0" value="<?php echo $pageOrder; ?>">
			</label>
		</div>

		<div class="col span11 omega">
			<label>
				<?php echo $titleLabel; ?>
				<input name="page[title]" type="text" value="<?php echo $pageTitle; ?>">
			</label>
		</div>
	</div>

</fieldset>
