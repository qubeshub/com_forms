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
 * @author    Anthony Fuentes <fuentesa@purdue.edu>
 * @copyright Copyright 2005-2015 HUBzero Foundation, LLC.
 * @license   http://opensource.org/licenses/MIT MIT
 */

// No direct access
defined('_HZEXEC_') or die();

$this->css('formList');

$formListUrl = $this->formListUrl;
$forms = $this->forms;
$query = $this->query;
$searchFormAction = $this->searchFormAction;

$this->view('_forms_breadcrumbs', 'shared')
	->set('breadcrumbs', [])
	->set('page', 'Forms list')
	->display();
?>

<section class="main section">
	<div class="grid">

		<div class="col span2">
			<?php
				$this->view('_landing_sidebar')
					->set('query', $query)
					->set('searchFormAction', $searchFormAction)
					->display();
			?>
		</div>

		<div class="col span10 omega">
			<?php
				$this->view('_form_list')
					->set('forms', $forms)
					->display();
			?>

			<form method="POST" action="<?php echo $formListUrl; ?>">
				<?php echo $forms->pagination; ?>
			</form>
		</div>

	</div>
</section>
