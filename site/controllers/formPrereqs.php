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

namespace Components\Forms\Site\Controllers;

use Hubzero\Component\SiteController;

$componentPath = Component::path('com_forms');

require_once "$componentPath/helpers/formsRouter.php";
require_once "$componentPath/helpers/pageBouncer.php";
require_once "$componentPath/helpers/params.php";
require_once "$componentPath/helpers/formPrereqsFactory.php";
require_once "$componentPath/helpers/relationalCrudHelper.php";
require_once "$componentPath/models/form.php";
require_once "$componentPath/models/formPrerequisite.php";

use Components\Forms\Helpers\FormsRouter as RoutesHelper;
use Components\Forms\Helpers\Params;
use Components\Forms\Helpers\PageBouncer;
use Components\Forms\Helpers\FormPrereqsFactory;
use Components\Forms\Helpers\RelationalCrudHelper as CrudHelper;
use Components\Forms\Models\Form;
use Components\Forms\Models\FormPrerequisite;

class FormPrereqs extends SiteController
{

	/**
	 * Task mapping
	 *
	 * @var  array
	 */
	protected $_taskMap = [
		'__default' => 'list'
	];

	/**
	 * Parameter whitelist
	 *
	 * @var  array
	 */
	protected static $_paramWhitelist = [
		'form_id',
		'order',
		'prereqs',
		'prerequisite_id',
		'prerequisite_scope'
	];

	/**
	 * Executes the requested task
	 *
	 * @return   void
	 */
	public function execute()
	{
		$this->_bouncer = new PageBouncer(['component' => $this->_option]);
		$this->_crudHelper = new CrudHelper([
			'controller' => $this,
			'errorSummary' => Lang::txt('COM_FORMS_NOTICES_FAILED_STEPS_UPDATE')
		]);
		$this->_factory = new FormPrereqsFactory();
		$this->_params = new Params(['whitelist' => self::$_paramWhitelist]);
		$this->name = $this->_controller;
		$this->_routes = new RoutesHelper();

		parent::execute();
	}

	/**
	 * Renders list of given form's prerequisites
	 *
	 * @return   void
	 */
	public function listTask()
	{
		$this->_bouncer->redirectUnlessAuthorized('core.create');

		$formId = $this->_params->getInt('form_id');
		$form = Form::oneOrFail($formId);
		$forms = Form::possiblePrereqsFor($form);

		$prereqs =  $form->getPrerequisites()
			->order('order', 'asc')
			->rows();

		$updateTaskUrl = $this->_routes->prereqsUpdateUrl($formId);

		$this->view
			->set('form', $form)
			->set('forms', $forms)
			->set('formAction', $updateTaskUrl)
			->set('prereqs', $prereqs)
			->display();
	}

	/**
	 * Attempts to update prerequisite records
	 *
	 * @return   void
	 */
	public function updateTask()
	{
		$this->_bouncer->redirectUnlessAuthorized('core.create');

		$formId = $this->_params->getInt('form_id');
		$form = Form::oneOrFail($formId);
		$currentPrereqs =  $form->getPrereqsInArray();
		$submittedPrereqsInfo = $this->_params->get('prereqs');
		$updateResult = $this->_factory->updateFormsPrereqs($currentPrereqs, $submittedPrereqsInfo);

		if ($updateResult->succeeded())
		{
			$forwardingUrl = $this->_routes->formsPrereqsUrl($formId);
			$message = Lang::txt('COM_FORMS_NOTICES_SUCCESSFUL_STEPS_UPDATE');
			$this->_crudHelper->successfulUpdate($forwardingUrl, $message);
		}
		else
		{
			$this->_crudHelper->failedUpdate($updateResult);
		}
	}

	/**
	 * Redirects to listTask
	 *
	 * @return   void
	 */
	public function editTask()
	{
		$this->setView($this->name, 'list');
		$this->listTask();
	}

	/**
	 * Renders new prerequisite view
	 *
	 * @return   void
	 */
	public function newTask($prereq = null, $args = [])
	{
		$formId = isset($args['form_id']) ? $args['form_id'] : $this->_params->getInt('form_id');
		$form = Form::oneOrFail($formId);

		$this->_bouncer->redirectUnlessCanEditForm($form);

		$forms = Form::possiblePrereqsFor($form);

		$prereq = $prereq ? $prereq: FormPrerequisite::blank();
		$createTaskUrl = $this->_routes->prereqsCreateUrl();

		$this->view
			->set('action', $createTaskUrl)
			->set('form', $form)
			->set('forms', $forms)
			->set('prereq', $prereq)
			->display();
	}

	/**
	 * Attempts to create a form prerequisite
	 *
	 * @return   void
	 */
	public function createTask()
	{
		$prereqData = $this->_params->getArray('prereq');
		$formId = $prereqData['form_id'];
		$form = Form::oneOrFail($formId);

		$this->_bouncer->redirectUnlessCanEditForm($form);

		$prereqData = $this->_params->getArray('prereq');
		$prereqData['created'] = Date::toSql();
		$prereqData['created_by'] = User::get('id');
		$prereq = FormPrerequisite::blank();
		$prereq->set($prereqData);

		if ($prereq->save())
		{
			$id = $prereq->get('id');
			$forwardingUrl = $this->_routes->formsPrereqsUrl($formId);
			$message = Lang::txt('COM_FORMS_STEP_SAVE_SUCCESS');
			$this->_crudHelper->successfulCreate($forwardingUrl, $message);
		}
		else
		{
			$this->_crudHelper->failedCreate($prereq, ['form_id' => $formId]);
		}
	}

}
