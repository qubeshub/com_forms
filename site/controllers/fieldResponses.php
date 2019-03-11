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

require_once "$componentPath/helpers/comFormsPageBouncer.php";
require_once "$componentPath/helpers/fieldsResponsesFactory.php";
require_once "$componentPath/helpers/formPageElementDecorator.php";
require_once "$componentPath/helpers/formsRouter.php";
require_once "$componentPath/helpers/pagesRouter.php";
require_once "$componentPath/helpers/params.php";
require_once "$componentPath/helpers/relationalCrudHelper.php";
require_once "$componentPath/models/fieldResponse.php";
require_once "$componentPath/models/form.php";
require_once "$componentPath/models/formPage.php";

use Components\Forms\Helpers\ComFormsPageBouncer as PageBouncer;
use Components\Forms\Helpers\FieldsResponsesFactory;
use Components\Forms\Helpers\FormPageElementDecorator as ElementDecorator;
use Components\Forms\Helpers\FormsRouter as RoutesHelper;
use Components\Forms\Helpers\PagesRouter;
use Components\Forms\Helpers\Params;
use Components\Forms\Helpers\RelationalCrudHelper as CrudHelper;
use Components\Forms\Models\FieldResponse;
use Components\Forms\Models\Form;
use Components\Forms\Models\FormPage;
use Hubzero\Component\SiteController;

class FieldResponses extends SiteController
{

	/**
	 * Task mapping
	 *
	 * @var  array
	 */
	protected $_taskMap = [
		'__default' => 'fill'
	];

	/**
	 * Parameter whitelist
	 *
	 * @var  array
	 */
	protected static $_paramWhitelist = [
		'form_id',
		'ordinal',
		'page_id'
	];

	/**
	 * Executes the requested task
	 *
	 * @return   void
	 */
	public function execute()
	{
		$this->_crudHelper = new CrudHelper(['controller' => $this]);
		$this->_decorator = new ElementDecorator();
		$this->_factory = new FieldsResponsesFactory();
		$this->_pageBouncer = new PageBouncer();
		$this->_pagesRouter = new PagesRouter();
		$this->_params = new Params(
			['whitelist' => self::$_paramWhitelist]
		);
		$this->_routes = new RoutesHelper();

		parent::execute();
	}

	/**
	 * Renders page fill page
	 *
	 * @return   void
	 */
	public function fillTask()
	{
		$this->_setFormAndPage();
		$this->_pageBouncer->redirectIfFormNotOpen($this->_form);
		$this->_pageBouncer->redirectIfPrereqsNotAccepted($this->_form);

		$fieldsResponsesCreateUrl = $this->_routes->fieldsResponsesCreateUrl();
		$pageElements = $this->_page->getFields()
			->order('order', 'asc')
			->rows();
		$userId = User::get('id');
		$decoratedPageElements = $this->_decorator->decorateForRendering($pageElements, $userId);

		$this->view
			->set('form', $this->_form)
			->set('page', $this->_page)
			->set('pageElements', $decoratedPageElements)
			->set('responsesCreateUrl', $fieldsResponsesCreateUrl)
			->display();
	}

	/**
	 * Attempts to create field response records
	 *
	 * @return   void
	 */
	public function createTask()
	{
		$this->_setFormAndPage();
		$this->_pageBouncer->redirectIfFormNotOpen($this->_form);

		$pageId = $this->_page->get('id');
		$userId = User::get('id');
		$responses = $this->_page->responsesInArray($userId);
		$responsesData = $this->_params->get('responses', []);
		$updateResult = $this->_factory->updateFieldsResponses($responses, $responsesData);

		if ($updateResult->succeeded())
		{
			$this->_updateFormResponse($responses);
			$forwardingUrl = $this->_pagesRouter->nextPageUrl($this->_page);
			$message = Lang::txt('COM_FORMS_NOTICES_FIELD_RESPONSES_SUCCESSFUL_UPDATE');
			$this->_crudHelper->successfulUpdate($forwardingUrl, $message);
		}
		else
		{
			$forwardingUrl = $this->_routes->formsPageResponseUrl(['page_id' => $pageId]);
			$message = Lang::txt('COM_FORMS_NOTICES_FIELD_RESPONSES_FAILED_UPDATE');
			$this->_crudHelper->failedBatchUpdate($forwardingUrl, $updateResult, $message);
		}
	}

	/**
	 * Updates form responses modified attribute
	 *
	 * @return   void
	 */
	protected function _updateFormResponse($responses)
	{
		if (count($responses) > 0)
		{
			$response = $responses[0]->getFormResponse();
			$response->set('modified', Date::toSql());
			$response->save();
		}
	}

	/**
	 * Sets form and page using request data
	 *
	 * @return   void
	 */
	protected function _setFormAndPage()
	{
		$this->_retrievePage();
		$this->_retrieveForm();

		if (!$this->_form && !!$this->_page)
		{
			$this->_form = $this->_page->getForm();
		}

		if (!$this->_page && !!$this->_form)
		{
			$position = $this->_params->getInt('ordinal', 1);
			$this->_page = $this->_form->getPageOrdinal($position);
		}
	}

	/**
	 * Retrieves page using request data
	 *
	 * @return   void
	 */
		protected function _retrievePage()
		{
			if ($pageId = $this->_params->getInt('page_id'))
			{
				$this->_page = FormPage::oneOrFail($pageId);
			}
		}

	/**
	 * Retrieves form using request data
	 *
	 * @return   void
	 */
	protected function _retrieveForm()
	{
		if ($formId = $this->_params->getInt('form_id'))
		{
			$this->_form = Form::oneOrFail($formId);
		}
	}

}
