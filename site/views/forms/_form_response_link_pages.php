<?php
/*
 * @package   hubzero-cms
 * @copyright Copyright 2005-2015 HUBzero Foundation, LLC.
 * @license   http://opensource.org/licenses/MIT MIT
 */

// No direct access
defined('_HZEXEC_') or die();

$componentPath = Component::path('com_forms');

require_once "$componentPath/helpers/formsRouter.php";
use Components\Forms\Helpers\FormsRouter as RoutesHelper;

$formId = $this->formId;
$pages = $this->pages;
$routes = new RoutesHelper();
$orderedPages = $pages->order('order', 'asc')->rows();
$pageCount = $orderedPages->count();
$i = 1;
?>

<span>
	<?php
		echo Lang::txt('COM_FORMS_HEADINGS_PAGES');
		foreach ($orderedPages as $page):
			$pageUrl = $routes->formsPageResponseUrl([
				'form_id' => $formId, 'ordinal' => $i
			]);
	?>
		<span class="page-number">
			<a href="<?php echo $pageUrl; ?>">
				<?php echo $i; $i++; ?>
			</a>
			<?php if ($i <= $pageCount) echo ','; ?>
		</span>
	<?php endforeach; ?>
</span>
