<?php

// No direct access
defined('_HZEXEC_') or die();

$responses = $this->responses;

?>

<ul class="responses-list">
	<?php
		foreach ($responses as $response):
			$this->view('_response_item')
				->set('response', $response)
				->display();
		endforeach;
	?>
</ul>
