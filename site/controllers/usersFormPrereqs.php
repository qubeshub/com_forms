<?php
/*
 * @package   hubzero-cms
 * @copyright Copyright 2005-2015 HUBzero Foundation, LLC.
 * @license   http://opensource.org/licenses/MIT MIT
 */

namespace Components\Forms\Site\Controllers;

$componentPath = Component::path('com_forms');

require_once "$componentPath/helpers/formsAuth.php";
require_once "$componentPath/helpers/pageBouncer.php";
require_once "$componentPath/helpers/params.php";
require_once "$componentPath/models/form.php";
require_once "$componentPath/models/formResponse.php";

use Components\Forms\Helpers\FormsAuth as AuthHelper;
use Components\Forms\Helpers\PageBouncer;
use Components\Forms\Helpers\Params;
use Components\Forms\Models\Form;
use Components\Forms\Models\FormResponse;
use Hubzero\Component\SiteController;

class UsersFormPrereqs extends SiteController
{

	/**
	 * Parameter whitelist
	 *
	 * @var  array
	 */
	protected static $_paramWhitelist = [
		'form_id',
		'user_id'
	];

	/**
	 * Executes the requested task
	 *
	 * @return   void
	 */
	public function execute()
	{
		$this->_auth = new AuthHelper();
		$this->_bouncer = new PageBouncer(['component' => $this->_option]);
		$this->_params = new Params(['whitelist' => self::$_paramWhitelist]);

		parent::execute();
	}

	/**
	 * Renders list of form's prereqs pertaining to given user
	 *
	 * @return   void
	 */
	public function listTask()
	{
		$this->_bouncer->redirectUnlessAuthorized('core.create');

		$formId = $this->_params->getInt('form_id');
		$userId = $this->_params->getInt('user_id');

		$form = Form::oneOrFail($formId);
		$response = FormResponse::all()
			->whereEquals('form_id', $formId)
			->whereEquals('user_id', $userId)
			->row();

		$isComponentAdmin = $this->_auth->currentCanCreate();

		$this->view
			->set('form', $form)
			->set('response', $response)
			->set('userIsAdmin', $isComponentAdmin)
			->display();
	}

}
