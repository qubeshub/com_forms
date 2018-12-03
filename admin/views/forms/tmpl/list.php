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
 * @copyright Copyright 2005-2015 HUBzero Foundation, LLC.
 * @license   http://opensource.org/licenses/MIT MIT
 */

// No direct access
defined('_HZEXEC_') or die();

$component = $this->option;
$controller = $this->controller;
$permissions = $this->permissions;
$toolbarTitle = $this->title;

Toolbar::title($toolbarTitle);

if ($permissions->get('core.manage'))
{
	Toolbar::preferences($component, '550');
}

?>

<form action="<?php echo 'TODO'; ?>" method="post" name="adminForm">

	<fieldset id="filter-bar">
		<label for="filter_search"><?php echo Lang::txt('JSEARCH_FILTER'); ?>:</label>
		<input type="text" name="search" id="filter_search" value="<?php echo ''; ?>" placeholder="..." />

		<input type="submit" value="<?php echo "Search"; ?>" />
		<button id="clear-search" type="button">
			<?php echo Lang::txt('JSEARCH_FILTER_CLEAR'); ?>
		</button>
	</fieldset>

	<?php echo Html::input('token'); ?>

	<!-- Filtering dependencies -->
	<!-- Toolbar dependencies -->
	<input type="hidden" name="controller" value="<?php echo $controller; ?>" />
	<input type="hidden" name="option" value="<?php echo $component ?>" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="task" />

</form>
