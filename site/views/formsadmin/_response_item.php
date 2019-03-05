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

$checkboxName = $this->checkboxName;
$response = $this->response;
$reviewer = $response->getReviewer();
$reviewerId = $reviewer->get('id');
$reviewerName = $reviewer->get('name');
$responseAccepted = $response->get('accepted');
$responseCreated = $response->get('created');
$responseId = $response->get('id');
$responseModified = $response->get('modified');
$responseProgress = $response->requiredCompletionPercentage();
$responseSubmitted = $response->get('submitted');
$user = $response->getUser();
$userId = $user->get('id');
$usersName = $user->get('name');
?>

<tr class="response-item">

	<td>
		<?php
			$this->view('_link', 'shared')
				->set('content', $responseId)
				->set('urlFunction', 'adminResponseReviewUrl')
				->set('urlFunctionArgs', [$responseId])
				->display();
		?>
	</td>

	<td>
		<?php
			$this->view('_link', 'shared')
				->set('content', $usersName)
				->set('urlFunction', 'userProfileUrl')
				->set('urlFunctionArgs', [$userId])
				->display();
		?>
	</td>

	<td>
		<?php echo "$responseProgress%"; ?>
	</td>

	<td>
		<?php
			$this->view('_date', 'shared')
				->set('date', $responseCreated)
				->display();
		?>
	</td>

	<td>
		<?php
			$this->view('_date', 'shared')
				->set('date', $responseModified)
				->display();
		?>
	</td>

	<td>
		<?php
			$this->view('_date', 'shared')
				->set('date', $responseSubmitted)
				->display();
		?>
	</td>

	<td>
		<?php
			$this->view('_date', 'shared')
				->set('date', $responseAccepted)
				->display();
		?>
	</td>

	<td>
		<?php
			$this->view('_link', 'shared')
				->set('content', $reviewerName)
				->set('urlFunction', 'userProfileUrl')
				->set('urlFunctionArgs', [$reviewerId])
				->display();
		?>
	</td>

</tr>
