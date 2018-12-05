<?php
/*
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

$this->css('formSearchForm');
$this->js('searchForm');

$action = $this->action;
$query = $this->query;
$queryArchived = $query->get('archived');
$queryClosingTime = $query->get('closing_time');
$queryClosingTimeRelative = $query->get('closing_time_relative_operator');
$queryDisabled = $query->get('disabled');
$queryLocked = $query->get('responses_locked');
$queryName = $query->get('name');
$queryOpeningTime = $query->get('opening_time');
$queryOpeningTimeRelative = $query->get('opening_time_relative_operator');
?>

<form class="search-form" method="post" action="<?php echo $action; ?>">

	<div class="row">
		<span class="header">
			<span class="master-caret fontcon" data-visible="true">
				&#xf0d8;
			</span>
		</span>
	</div>

	<div class="row">
		<?php
			$this->view('_collapsible_field_header', 'shared')
				->set('title', Lang::txt('COM_FORMS_FIELDS_NAME'))
				->set('isRequired', false)
				->display();
		?>
		<div class="content">
			<input type="text" name="query[name]" value="<?php echo $queryName; ?>">
		</div>
		<hr>
	</div>

	<div class="row">
		<?php
			$this->view('_collapsible_field_header', 'shared')
				->set('title', Lang::txt('COM_FORMS_FIELDS_OPENING_DATE'))
				->set('isRequired', false)
				->display();
		?>
		<div class="content">
			<?php
				$this->view('_relative_date_fields', 'shared')
					->set('selectFieldName', 'query[opening_time_relative_operator]')
					->set('relativeOperatorValue', $queryOpeningTimeRelative)
					->set('dateFieldName', 'query[opening_time]')
					->set('dateValue', $queryOpeningTime)
					->display();
			?>
		</div>
		<hr>
	</div>

	<div class="row">
		<?php
			$this->view('_collapsible_field_header', 'shared')
				->set('title', Lang::txt('COM_FORMS_FIELDS_CLOSING_DATE'))
				->set('isRequired', false)
				->display();
		?>
		<div class="content">
			<?php
				$this->view('_relative_date_fields', 'shared')
					->set('selectFieldName', 'query[closing_time_relative_operator]')
					->set('relativeOperatorValue', $queryClosingTimeRelative)
					->set('dateFieldName', 'query[closing_time]')
					->set('dateValue', $queryClosingTime)
					->display();
			?>
		</div>
		<hr>
	</div>

	<div class="row">
		<?php
			$this->view('_collapsible_field_header', 'shared')
				->set('title', Lang::txt('COM_FORMS_FIELDS_RESPONSES'))
				->set('isRequired', false)
				->display();
		?>
		<div class="content">
			<?php
				$this->view('_binary_inline_radio_list', 'shared')
					->set('falseTextKey', 'COM_FORMS_FIELDS_RESPONSES_EDITABLE')
					->set('flag', $queryLocked )
					->set('name', 'query[responses_locked]')
					->set('trueTextKey', 'COM_FORMS_FIELDS_RESPONSES_LOCKED')
					->display();
			?>
		</div>
		<hr>
	</div>

	<div class="row">
		<?php
			$this->view('_collapsible_field_header', 'shared')
				->set('title', Lang::txt('COM_FORMS_FIELDS_DISABLED'))
				->set('isRequired', false)
				->display();
		?>
		<div class="content">
			<?php
				$this->view('_binary_inline_radio_list', 'shared')
					->set('flag', $queryDisabled)
					->set('name', 'query[disabled]')
					->display();
			?>
		</div>
		<hr>
	</div>

	<div class="row">
		<?php
			$this->view('_collapsible_field_header', 'shared')
				->set('title', Lang::txt('COM_FORMS_FIELDS_ARCHIVED'))
				->set('isRequired', false)
				->display();
		?>
		<div class="content">
			<?php
				$this->view('_binary_inline_radio_list', 'shared')
					->set('flag', $queryArchived)
					->set('name', 'query[archived]')
					->display();
			?>
		</div>
		<hr>
	</div>

	<div class="row">
			<?php echo Html::input('token'); ?>
			<input class="btn" type="submit"
				value="<?php echo Lang::txt('COM_FORMS_FIELDS_SEARCH'); ?>">
	</div>

</form>
