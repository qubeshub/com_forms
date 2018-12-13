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

$componentPath = Component::path('com_forms');

require_once "$componentPath/helpers/formsRouter.php";
require_once "$componentPath/helpers/pageBouncer.php";
require_once "$componentPath/models/form.php";
require_once "$componentPath/models/formPage.php";
require_once "$componentPath/helpers/params.php";
require_once "$componentPath/helpers/relationalCrudHelper.php";

use Components\Forms\Helpers\FormsRouter as RoutesHelper;
use Components\Forms\Helpers\PageBouncer;
use Components\Forms\Models\Form;
use Components\Forms\Models\FormPage;
use Components\Forms\Helpers\Params;
use Components\Forms\Helpers\RelationalCrudHelper as CrudHelper;
use Hubzero\Component\SiteController;

class FormPages extends SiteController
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
		'order',
		'title',
		'form_id'
	];

	/**
	 * Executes requested task
	 *
	 * @return   void
	 */
	public function execute()
	{
		$this->_bouncer = new PageBouncer([
			'component' => $this->_option
		]);
		$this->_crudHelper = new CrudHelper([
			'controller' => $this,
			'errorSummary' => Lang::txt('COM_FORMS_FORM_SAVE_ERROR')
		]);
		$this->name = $this->_controller;
		$this->_params = new Params(
			['whitelist' => self::$_paramWhitelist]
		);
		$this->_routes = new RoutesHelper();

		parent::execute();
	}

	/**
	 * Renders list of given form's pages
	 *
	 * @return   void
	 */
	public function listTask()
	{
		$this->_bouncer->redirectUnlessAuthorized('core.create');

		$formId = $this->_params->get('form_id');
		$form = Form::oneOrFail($formId);

		$pages = FormPage::all()
			->whereEquals('form_id', $formId)
			->order('order', 'asc')
			->rows();

		$this->view
			->set('form', $form)
			->set('pages', $pages)
			->display();
	}

	/**
	 * Renders new pages view
	 *
	 * @return   void
	 */
	public function newTask($page = false)
	{
		$this->_bouncer->redirectUnlessAuthorized('core.create');

		$formId = $this->_params->get('form_id');
		$form = Form::oneOrFail($formId);

		$page = $page ? $page : FormPage::blank();
		$createTaskUrl = $this->_routes->formsPagesCreateUrl($formId);

		$this->view
			->set('form', $form)
			->set('action', $createTaskUrl)
			->set('page', $page)
			->display();
	}

	/**
	 * Attempts to create page record using submitted data
	 *
	 * @return   void
	 */
	public function createTask()
	{
		$this->_bouncer->redirectUnlessAuthorized('core.create');

		$formId = $this->_params->get('form_id');
		$pageData = $this->_params->getArray('page');
		$pageData['created'] = Date::toSql();
		$pageData['created_by'] = User::get('id');
		$pageData['form_id'] = $formId;

		$page = FormPage::blank();
		$page->set($pageData);

		if ($page->save())
		{
			$pageId = $page->get('id');
			$forwardingUrl = $this->_routes->pagesEditUrl($pageId);
			$successMessage = Lang::txt('COM_FORMS_PAGE_SAVE_SUCCESS');
			$this->_crudHelper->successfulCreate($forwardingUrl, $successMessage);
		}
		else
		{
			$this->_crudHelper->failedCreate($page);
		}
	}

	/**
	 * Renders page edit view
	 *
	 * @return   void
	 */
	public function editTask($page = false)
	{
		$this->_bouncer->redirectUnlessAuthorized('core.create');

		$pageId = $this->_params->get('id');
		$page = $page ? $page : FormPage::oneOrFail($pageId);
		$form = $page->getForm();

		$updateTaskUrl = $this->_routes->pagesUpdateUrl($pageId);

		$this->view
			->set('action', $updateTaskUrl)
			->set('form', $form)
			->set('page', $page)
			->display();
	}

	/**
	 * Handles updating of given page using provided data
	 *
	 * @return   void
	 */
	public function updateTask()
	{
		$this->_bouncer->redirectUnlessAuthorized('core.create');

		$pageId = $this->_params->get('id');
		$pageData = $this->_params->getArray('page');
		$pageData['modified'] = Date::toSql();
		$pageData['modified_by'] = User::get('id');

		$page = FormPage::oneOrFail($pageId);
		$page->set($pageData);

		if ($page->save())
		{
			$forwardingUrl = $this->_routes->pagesEditUrl($pageId);
			$message = Lang::txt('COM_FORMS_PAGE_SAVE_SUCCESS');
			$this->_crudHelper->successfulUpdate($forwardingUrl, $message);
		}
		else
		{
			$this->_crudHelper->failedUpdate($page);
		}
	}

}
