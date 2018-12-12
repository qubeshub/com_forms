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

$this->css('formPagesList');

$form = $this->form;
$formId = $form->get('id');
$formName = $form->get('name');
$pages = $this->pages;

$breadcrumbs = [
	'Forms' => '/forms',
	 $formName => "/forms/forms/$formId/display",
	'Edit' => "/forms/forms/$formId/edit",
	'Pages' => ''
];
$page = "Form's Pages";

$this->view('_breadcrumbs', 'shared')
	->set('breadcrumbs', $breadcrumbs)
	->set('page', $page)
	->display();
?>

<section class="main section">
	<div class="grid">

		<div class="row">
			<?php
				$this->view('_form_edit_nav', 'shared')
					->set('current', 'Pages')
					->set('formId', $formId)
					->display();
			?>
		</div>

		<div class="row">
			<?php
				$this->view('_pages_list_area')
					->set('pages', $pages)
					->display();
			?>
		</div>

	<div class="row link-row">
		<?php
			$this->view('_page_create_link')
				->set('formId', $formId)
				->display();
		?>
	</div>

	</div>
</section>
