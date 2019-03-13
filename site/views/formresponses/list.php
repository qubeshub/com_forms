<?php
/*
 * @package   hubzero-cms
 * @copyright Copyright 2005-2015 HUBzero Foundation, LLC.
 * @license   http://opensource.org/licenses/MIT MIT
 */

// No direct access
defined('_HZEXEC_') or die();

$this->css('formResponsesList');

$responses = $this->responses;
$responsesListUrl = $this->listUrl;

$breadcrumbs = [
	'Forms' => ['formListUrl'],
	'Responses' => ['usersResponsesUrl']
];
$this->view('_forms_breadcrumbs', 'shared')
	->set('breadcrumbs', $breadcrumbs)
	->set('page', "Responses")
	->display();
?>

<section class="main section">
	<div class="grid">

		<div class="col span7 omega">
			<?php
				$this->view('_response_list')
					->set('responses', $responses)
					->display();
			?>

			<form method="POST" action="<?php echo $responsesListUrl; ?>">
				<?php echo $responses->pagination; ?>
			</form>
		</div>

	</div>
</section>
