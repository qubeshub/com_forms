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

namespace Components\Forms\Helpers;

$componentPath = Component::path('com_forms');

require_once "$componentPath/helpers/componentAuth.php";

use Components\Forms\Helpers\ComponentAuth;

class FormsAuth extends ComponentAuth
{

	/**
	 * Constructs FormsAuth instance
	 *
	 * @param    array   $args   Instantiation state
	 * @return   void
	 */
	public function __construct($args = [])
	{
		$args['component'] = 'com_forms';

		parent::__construct($args);
	}

	/**
	 * Determines if current user can edit given form
	 *
	 * @param    object   $form     Form instance
	 * @return   bool
	 */
	public function canCurrentUserEditForm($form)
	{
		$currentUsersId = User::get('id');

		$canEdit = $this->_canUserEditForm($form, $currentUsersId);

		return $canEdit;
	}

	/**
	 * Determines if form can be edited by user w/ given ID
	 *
	 * @param    object   $form     Form instance
	 * @param    int      $userId   Given user's ID
	 * @return   bool
	 */
	protected function _canUserEditForm($form, $userId)
	{
		$userIsAdmin = $this->currentIsAuthorized('core.admin');
		$userCanCreate = $this->currentIsAuthorized('core.create');
		$userOwnsForm = $form->isOwnedBy($userId);

		$canEdit = $userIsAdmin || ($userCanCreate && $userOwnsForm);

		return $canEdit;
	}

}
