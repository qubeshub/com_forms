<?php
/*
 * @package   hubzero-cms
 * @copyright Copyright 2005-2015 HUBzero Foundation, LLC.
 * @license   http://opensource.org/licenses/MIT MIT
 */

// No direct access
defined('_HZEXEC_') or die();

$this->css('responseFeed');

$form = $this->form;
$formId = $form->get('id');
$formName = $form->get('name');
$response = $this->response;
$responseId = $response->get('id');
$tagString = $this->tagString;
$tagUpdateUrl = $this->tagUpdateUrl;
$user = $response->getUser();
$userName = $user->get('name');

$breadcrumbs = [
	 $formName => ['formsDisplayUrl', [$formId]],
	'Admin' => ['formsEditUrl', [$formId]],
	'Responses' => ['formsResponseList', [$formId]],
	$userName => ['responseFeedUrl', [$responseId]]
];

$this->view('_forms_breadcrumbs', 'shared')
	->set('breadcrumbs', $breadcrumbs)
	->set('page', "$formName Feed")
	->display();
?>

<section class="main section">
	<div class="grid">

		<div class="col span12 nav omega">
			<?php
				$this->view('_response_details_nav', 'shared')
					->set('current', 'Feed')
					->set('responseId', $responseId)
					->display();
			?>
		</div>

		<div class="col span6 response-details">
			<?php
				$this->view('_response_details')
					->set('form', $form)
					->set('response', $response)
					->set('tagString', $tagString)
					->set('tagUpdateUrl', $tagUpdateUrl)
					->display();
			?>
		</div>

	</div>
</section>
