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

$forms = $this->forms;
$prereq = $this->prereq;
$prereqId = $prereq->get('id');
$order = $prereq->get('order');
$scopeId = $prereq->get('prerequisite_id');
$title = $prereq->getParent('name');
?>

<li class="prereq-item">
	<span class="grid">

		<span class="col span1 offset1">
			<input name="prereqs[<?php echo $prereqId; ?>][id]"
				type="hidden"
				value="<?php echo $prereqId; ?>">
			<input name="prereqs[<?php echo $prereqId; ?>][order]"
				type="number"
				min="1"
				value="<?php echo $order; ?>"
				class="item-input" >
		</span>

		<span class="col span3">
			<?php
				$this->view('_form_select')
					->set('forms', $forms)
					->set('name', "prereqs[$prereqId][prerequisite_id]")
					->set('scopeId', $scopeId)
					->display();
			?>
		</span>

	</span>
</li>
