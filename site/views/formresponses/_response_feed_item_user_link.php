<?php
/**
 * @package    hubzero-cms
 * @copyright  Copyright (c) 2005-2020 The Regents of the University of California.
 * @license    http://opensource.org/licenses/MIT MIT
 */

// No direct access
defined('_HZEXEC_') or die();

$item = $this->item;
$authorId = $item->get('created_by');
$author = User::one($authorId);
$authorName = $author->get('name');

if ($authorId == User::get('id'))
{
  $authorName = Lang::txt('COM_FORMS_HEADINGS_YOU');
}

?>

<span>
	<?php
		$this->view('_link', 'shared')
			->set('content', $authorName)
			->set('urlFunction', 'userProfileUrl')
			->set('urlFunctionArgs', [$authorId])
			->display();
	?>
</span>
