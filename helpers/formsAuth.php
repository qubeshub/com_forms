<?php
/*
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
