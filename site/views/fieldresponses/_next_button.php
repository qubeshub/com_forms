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

$classes = 'btn btn-success';
$formId = $this->formId;
$isLastPage = $this->isLastPage;
$pagePosition = $this->pagePosition;
$userShouldNotEditResponse = $this->formDisabled;

if ($isLastPage)
{
	$urlFunction = 'formResponseReviewUrl';
	$urlFunctionArgs = [$formId];
	$textKey = 'COM_FORMS_FIELDS_VALUES_REVIEW_RESPONSES';
}
else
{
	$urlFunction = 'formsPageResponseUrl';
	$urlFunctionArgs = [[
		'form_id' => $formId,
		'ordinal' => ($pagePosition + 1)
	]];
	$textKey = 'COM_FORMS_FIELDS_VALUES_NEXT_PAGE';
}
?>

<?php if ($userShouldNotEditResponse):	?>
	<span class="button-container">

		<?php
			$this->view('_link_lang', 'shared')
				->set('classes', $classes)
				->set('urlFunction', $urlFunction)
				->set('urlFunctionArgs', $urlFunctionArgs)
				->set('textKey', $textKey)
				->display();
		?>

	</span>
<?php endif; ?>
