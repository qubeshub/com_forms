<?php
/*
 * @package   hubzero-cms
 * @copyright Copyright 2005-2015 HUBzero Foundation, LLC.
 * @license   http://opensource.org/licenses/MIT MIT
 */

// No direct access
defined('_HZEXEC_') or die();

$this->css('adminResponse')
	->css('pageFill');

$acceptanceAction = $this->acceptanceAction;
$form = $this->form;
$formId = $form->get('id');
$formName = $form->get('name');
$pageElements = $this->pageElements;
$response = $this->response;
$responseId = $response->get('id');
$user = $response->getUser();
$userName = $user->get('name');
$respondentText = Lang::txt('COM_FORMS_HEADINGS_RESPONDENT', $userName);

$breadcrumbs = [
	 $formName => ['formsDisplayUrl', [$formId]],
	'Admin' => ['formsEditUrl', [$formId]],
	'Responses' => ['formsResponseList', [$formId]],
	$userName => ['responseFeedUrl', [$responseId]]
];

$this->view('_forms_breadcrumbs', 'shared')
	->set('breadcrumbs', $breadcrumbs)
	->set('page', "$formName $userName")
	->display();
?>

<section class="main section">

	<div>
		<h2>
			<?php echo $respondentText; ?>
		</h2>
	</div>

	<div>
		<?php
			$this->view('_form', 'shared')
				->set('action', '')
				->set('disabled', true)
				->set('elements', $pageElements)
				->set('title', $formName)
				->set('title', $formName)
				->display();
		?>
	</div>

	<div>
		<?php
			$this->view('_response_acceptance_form')
				->set('action', $acceptanceAction)
				->set('response', $response)
				->display();
		?>
	</div>

</section>