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

$this->css('pageFill');

$form = $this->form;
$formId = $form->get('id');
$formName = $form->get('name');
$page = $this->page;
$pageElements = $this->pageElements;
$pageId = $page->get('id');
$pageMetadata = (object) ['name' => 'page_id', 'value' => $pageId];
$pageTitle = $page->get('title');
$responsesCreateUrl = $this->responsesCreateUrl;
$submitClasses = 'btn btn-success';

if ($form->isLastPage($page))
{
	$submitValue = Lang::txt('COM_FORMS_FIELDS_VALUES_SAVE_AND_REVIEW');
}
else
{
	$submitValue = Lang::txt('COM_FORMS_FIELDS_VALUES_SAVE_AND_CONTINUE');
}

$breadcrumbs = [
	$formName => ['formsDisplayUrl', [$formId]],
	$pageTitle => ['formsPageResponseUrl', [['page_id' => $pageId]]]
];
$this->view('_forms_breadcrumbs', 'shared')
	->set('breadcrumbs', $breadcrumbs)
	->set('page', "$formName: $pageTitle")
	->display();
?>

<section class="main section">
	<div class="grid">

		<div class="row">
			<div class="col span12 omega">
				<?php
					$this->view('_form', 'shared')
						->set('action', $responsesCreateUrl)
						->set('elements', $pageElements)
						->set('hiddenMetadata', [$pageMetadata])
						->set('submitClasses', $submitClasses)
						->set('submitValue', $submitValue)
						->set('title', $pageTitle)
						->display();
				?>
			</div>
		</div>

	</div>
</section>
