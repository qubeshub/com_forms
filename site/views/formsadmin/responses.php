<?php
/*
 * @package   hubzero-cms
 * @copyright Copyright 2005-2015 HUBzero Foundation, LLC.
 * @license   http://opensource.org/licenses/MIT MIT
 */

// No direct access
defined('_HZEXEC_') or die();

$this->css('formAdminResponses');

$form = $this->form;
$formId = $form->get('id');
$formName = $form->get('name');
$responses = $this->responses;
$responseListUrl = $this->responseListUrl;
$paginationClass = $responses->count() > 4 ? '' : 'hidden';
$sortingCriteria = $this->sortingCriteria;

$breadcrumbs = [
	 $formName => ['formsDisplayUrl', [$formId]],
	'Admin' => ['formsEditUrl', [$formId]],
	'Responses' => ['formsResponseList', [$formId]]
];

$this->view('_forms_breadcrumbs', 'shared')
	->set('breadcrumbs', $breadcrumbs)
	->set('page', "$formName Responses")
	->display();
?>

<section class="main section">
	<div class="grid">

		<div class="col span12 nav omega">
			<?php
				$this->view('_form_edit_nav', 'shared')
					->set('current', 'Responses')
					->set('formId', $formId)
					->display();
			?>
		</div>

		<div class="col span12 omega">
			<?php
				$this->view('_response_list_area')
					->set('formId', $formId)
					->set('responses', $responses)
					->set('sortingAction', $responseListUrl)
					->set('sortingCriteria', $sortingCriteria)
					->display();
			?>

			<div class="<?php echo $paginationClass; ?>">
				<form method="POST" action="<?php echo $responseListUrl; ?>">
					<?php echo $responses->pagination; ?>
				</form>
			</div>
		</div>

	</div>
</section>
