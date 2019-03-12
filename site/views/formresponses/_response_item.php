<?php

// No direct access
defined('_HZEXEC_') or die();

$response = $this->response;
$form = $response->getForm();
$formId = $form->get('id');
$formName = $form->get('name');
?>

<li class="response-item">
	<span class="grid">

		<span class="col span5">
			<?php
				$this->view('_link', 'shared')
					->set('content', $formName)
					->set('urlFunction', 'formsDisplayUrl')
					->set('urlFunctionArgs', [$formId])
					->display();
			?>
		</span>

		<span class="col span7 omega">
			<?php
				$this->view('_response_status_notice')
					->set('form', $form)
					->set('response', $response)
					->display();
			?>
		</span>

	</span>
</li>
