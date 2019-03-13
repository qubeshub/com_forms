<?php
/*
 * @package   hubzero-cms
 * @copyright Copyright 2005-2015 HUBzero Foundation, LLC.
 * @license   http://opensource.org/licenses/MIT MIT
 */

namespace Components\Forms\Site\Controllers;

use Hubzero\Component\SiteController;

$componentPath = Component::path('com_forms');

require_once "$componentPath/helpers/comFormsPageBouncer.php";
require_once "$componentPath/helpers/formPageElementDecorator.php";
require_once "$componentPath/helpers/formsRouter.php";
require_once "$componentPath/helpers/params.php";
require_once "$componentPath/helpers/relationalCrudHelper.php";
require_once "$componentPath/helpers/virtualCrudHelper.php";
require_once "$componentPath/models/form.php";
require_once "$componentPath/models/formResponse.php";

use Components\Forms\Helpers\FormPageElementDecorator as ElementDecorator;
use Components\Forms\Helpers\FormsRouter as RoutesHelper;
use Components\Forms\Helpers\ComFormsPageBouncer as PageBouncer;
use Components\Forms\Helpers\Params;
use Components\Forms\Helpers\RelationalCrudHelper as RCrudHelper;
use Components\Forms\Helpers\VirtualCrudHelper as VCrudHelper;
use Components\Forms\Models\Form;
use Components\Forms\Models\FormResponse;
use Date;

class FormResponses extends SiteController
{

	/**
	 * Task mapping
	 *
	 * @var  array
	 */
	protected $_taskMap = [
		'__default' => 'display'
	];

	/**
	 * Parameter whitelist
	 *
	 * @var  array
	 */
	protected static $_paramWhitelist = [
		'form_id'
	];

	/**
	 * Executes the requested task
	 *
	 * @return   void
	 */
	public function execute()
	{
		$this->_crudHelper = new VCrudHelper([
			'errorSummary' => Lang::txt('COM_FORMS_NOTICES_FAILED_START')
		]);
		$this->_rCrudHelper = new RCrudHelper([
			'controller' => $this
		]);
		$this->_decorator = new ElementDecorator();
		$this->_pageBouncer = new PageBouncer();
		$this->_params = new Params(
			['whitelist' => self::$_paramWhitelist]
		);
		$this->_routes = new RoutesHelper();

		parent::execute();
	}

	/**
	 * Creates response for given form & user
	 * redirects to first page of given form
	 *
	 * @return   void
	 */
	public function startTask()
	{
		$formId = $this->_params->getInt('form_id');

		$response = $this->_createResponse();

		if ($response->isNew())
		{
			$formOverviewPage = $this->_routes->formsDisplayUrl($formId);
			$this->_crudHelper->failedCreate($response, $formOverviewPage);
		}
		else
		{
			$formsFirstPage = $this->_routes->formsPageResponseUrl([
				'form_id' => $formId, 'ordinal' => 1
			]);
			$responseStartedMessage = Lang::txt('COM_FORMS_NOTICES_SUCCESSFUL_START');
			$this->_crudHelper->successfulCreate($formsFirstPage, $responseStartedMessage);
		}
	}

	/**
	 * Creates response record using given data
	 *
	 * @param    array    $responseData   Response instantiation data
	 * @return   object
	 */
	protected function _createResponse($responseData = [])
	{
		$defaultData = [
			'form_id' => $this->_params->getInt('form_id'),
			'user_id' => User::get('id'),
			'created' => Date::toSql()
		];
		$combinedData = array_merge($defaultData, $responseData);

		$response = FormResponse::blank();
		$response->set($combinedData);

		$response->save();

		return $response;
	}

	/**
	 * Renders response review page
	 *
	 * @return   void
	 */
	public function reviewTask()
	{
		$formId = $this->_params->getInt('form_id');
		$form = Form::oneOrFail($formId);

		$this->_pageBouncer->redirectIfFormNotOpen($form);
		$this->_pageBouncer->redirectIfPrereqsNotAccepted($form);

		$pageElements = $form->getFieldsOrdered();
		$responseSubmitUrl = $this->_routes->formResponseSubmitUrl();
		$userId = User::get('id');
		$decoratedPageElements = $this->_decorator->decorateForRendering($pageElements, $userId);

		foreach ($pageElements as $element)
		{
			$element->_returnDefault = false;
		}

		$this->view
			->set('form', $form)
			->set('pageElements', $decoratedPageElements)
			->set('responseSubmitUrl', $responseSubmitUrl)
			->display();
	}

	/**
	 * Attempts to handle the submission of a form response for review
	 *
	 * @return   void
	 */
	public function submitTask()
	{
		$currentUsersId = User::get('id');
		$formId = $this->_params->getInt('form_id');
		$form = Form::oneOrFail($formId);
		$response = $form->getResponse($currentUsersId);

		$this->_pageBouncer->redirectIfResponseSubmitted($response);
		$this->_pageBouncer->redirectIfFormNotOpen($form);
		$this->_pageBouncer->redirectIfPrereqsNotAccepted($form);

		$currentTime = Date::toSql();
		$response->set('modified', $currentTime);
		$response->set('submitted', $currentTime);

		if ($response->save())
		{
			$forwardingUrl = $this->_routes->formListUrl();
			$successMessage = Lang::txt('COM_FORMS_NOTICES_FORM_RESPONSE_SUBMIT_SUCCESS');
			$this->_rCrudHelper->successfulUpdate($forwardingUrl, $successMessage);
		}
		else
		{
			$errorSummary = Lang::txt('COM_FORMS_NOTICES_FORM_RESPONSE_SUBMIT_ERROR');
			$forwardingUrl = $this->_routes->formResponseReviewUrl($formId);
			$this->_rCrudHelper->failedBatchUpdate($forwardingUrl, $response, $errorSummary);
		}
	}

	/**
	 * Renders list of users responses
	 *
	 * @return   void
	 */
	public function listTask()
	{
		$currentUserId = User::get('id');
		$responses = FormResponse::all()
			->whereEquals('user_id', $currentUserId)
			->paginated('limitstart', 'limit')
			->rows();
		$responsesListUrl = $this->_routes->usersResponsesUrl();

		$this->view
			->set('responses', $responses)
			->set('listUrl', $responsesListUrl)
			->display();
	}

}
