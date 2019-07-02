<?php
/*
 * @package   hubzero-cms
 * @copyright Copyright 2005-2015 HUBzero Foundation, LLC.
 * @license   http://opensource.org/licenses/MIT MIT
 */

// No direct access
defined('_HZEXEC_') or die();

$this->css('responseFeed');

$comment = $this->comment;
$createCommentUrl = $this->createCommentUrl;
$feedItems = $this->feedItems;
$form = $this->form;
$formId = $form->get('id');
$formName = $form->get('name');
$userIsAdmin = $this->userIsAdmin;
$response = $this->response;
$responseId = $response->get('id');
$tagString = $this->tagString;
$tagUpdateUrl = $this->tagUpdateUrl;
$user = $response->getUser();
$userName = $user->get('name');

$breadcrumbs = [$formName => ['formsDisplayUrl', [$formId]]];

if ($userIsAdmin)
{
  $breadcrumbs = array_merge($breadcrumbs, [
    'Admin' => ['formsEditUrl', [$formId]],
    'Responses' => ['formsResponseList', [$formId]],
    $userName => ['responseFeedUrl', [$responseId]]
  ]);
}
else
{
  $breadcrumbs['Response'] = ['responseFeedUrl', [$responseId]];
}

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

		<div class="col span6 response-feed-container omega">
			<?php
				$this->view('_response_feed')
					->set('comment', $comment)
					->set('createCommentUrl', $createCommentUrl)
					->set('feedItems', $feedItems)
					->set('formId', $formId)
					->set('responseId', $responseId)
					->display();
			?>
		</div>

	</div>
</section>
