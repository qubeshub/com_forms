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

require_once "$componentPath/helpers/formPageElementDecorator.php";
require_once "$componentPath/helpers/formsRouter.php";
require_once "$componentPath/helpers/pageBouncer.php";
require_once "$componentPath/helpers/params.php";
require_once "$componentPath/helpers/relationalCrudHelper.php";
require_once "$componentPath/models/form.php";
require_once "$componentPath/models/formResponse.php";

use Components\Forms\Helpers\FormPageElementDecorator as ElementDecorator;
use Components\Forms\Helpers\FormsRouter as RoutesHelper;
use Components\Forms\Helpers\PageBouncer;
use Components\Forms\Helpers\Params;
use Components\Forms\Helpers\RelationalCrudHelper as CrudHelper;
use Components\Forms\Models\Form;
use Components\Forms\Models\FormResponse;
use Hubzero\Component\SiteController;

$componentPath = Component::path('com_forms');

class FormsAdmin extends SiteController
{

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
		$this->_bouncer = new PageBouncer([
			'component' => $this->_option
		]);
		$this->_crudHelper = new CrudHelper(['controller' => $this]);
		$this->_decorator = new ElementDecorator();
		$this->_params = new Params(
			['whitelist' => self::$_paramWhitelist]
		);
		$this->_routes = new RoutesHelper();

		parent::execute();
	}

	/**
	 * Renders list of responses for given form
	 *
	 * @return   void
	 */
	public function responsesTask()
	{
		$this->_bouncer->redirectUnlessAuthorized('core.create');

		$formId = $this->_params->getInt('form_id');
		$form = Form::oneOrFail($formId);

		$formResponses = $form->getResponses()
			->paginate('limitstart', 'limit')
			->order('id', 'asc');
		$responseListUrl = $this->_routes->formsResponseList($formId);

		$this->view
			->set('form', $form)
			->set('responseListUrl', $responseListUrl)
			->set('responses', $formResponses)
			->display();
	}

	/**
	 * Renders given form response
	 *
	 * @return   void
	 */
	public function responseTask()
	{
		$this->_bouncer->redirectUnlessAuthorized('core.create');

		$responseId = $this->_params->getInt('response_id');
		$response = FormResponse::oneOrFail($responseId);
		$userId = $response->get('user_id');
		$form = $response->getForm();
		$pageElements = $form->getFieldsOrdered();
		$decoratedPageElements = $this->_decorator->decorateForRendering($pageElements, $userId);
		$reponseAcceptanceUrl = $this->_routes->responseApprovalUrl();

		foreach ($pageElements as $element)
		{
			$element->_returnDefault = false;
		}

		$this->view
			->set('acceptanceAction', $reponseAcceptanceUrl)
			->set('form', $form)
			->set('pageElements', $decoratedPageElements)
			->set('response', $response)
			->display();
	}

	/**
	 * Updates approval status of given form response
	 *
	 * @return   void
	 */
	public function approveTask()
	{
		$this->_bouncer->redirectUnlessAuthorized('core.create');

		$responseAccepted = !!$this->_params->get('accepted');
		$accepted = $responseAccepted ? Date::toSql() : null;
		$responseId = $this->_params->getInt('response_id');
		$response = FormResponse::oneOrFail($responseId);
		$formId = $response->getFormId();

		$response->set('reviewed_by', User::get('id'));
		$response->set('accepted', $accepted);

		if ($response->save())
		{
			$forwardingUrl = $this->_routes->formsResponseList($formId);
			$message = Lang::txt('Response acceptance udpated');
			$this->_crudHelper->successfulUpdate($forwardingUrl, $message);
		}
		else
		{
			$forwardingUrl = $this->_routes->adminResponseReviewUrl($responseId);
			$message = Lang::txt('The issues below prevented the response from being udpated.');
			$this->_crudHelper->failedBatchUpdate($forwardingUrl, $response, $message);
		}
	}

}
