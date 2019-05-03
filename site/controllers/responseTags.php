<?php
/*
 * @package   hubzero-cms
 * @copyright Copyright 2005-2015 HUBzero Foundation, LLC.
 * @license   http://opensource.org/licenses/MIT MIT
 */

namespace Components\Forms\Site\Controllers;

$componentPath = Component::path('com_forms');

require_once "$componentPath/helpers/formsRouter.php";
require_once "$componentPath/helpers/pageBouncer.php";
require_once "$componentPath/helpers/params.php";
require_once "$componentPath/helpers/sortableResponses.php";
require_once "$componentPath/helpers/tagsHelper.php";
require_once "$componentPath/models/form.php";

use Components\Forms\Helpers\PageBouncer;
use Components\Forms\Helpers\Params;
use Components\Forms\Helpers\FormsRouter as RoutesHelper;
use Components\Forms\Helpers\SortableResponses;
use Components\Forms\Helpers\TagsHelper;
use Components\Forms\Models\Form;
use Hubzero\Component\SiteController;

class ResponseTags extends SiteController
{

	/**
	 * Parameter whitelist
	 *
	 * @var  array
	 */
	protected static $_paramWhitelist = [
		'form_id',
		'response_ids'
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
		$this->_params = new Params(
			['whitelist' => self::$_paramWhitelist]
		);
		$this->_routes = new RoutesHelper();
		$this->_tagsHelper = new TagsHelper();

		parent::execute();
	}

	/**
	 * Renders response tagging page
	 *
	 * @return   void
	 */
  public function responsesTask()
  {
		$formId = $this->_params->getVar('form_id');
		$form = Form::oneOrFail($formId);

		$this->_bouncer->redirectUnlessCanEditForm($form);
		$this->_bouncer->redirectUnlessAuthorized('core.create');

		$responseIds = $this->_params->getVar('response_ids');
		$responses = $form->getResponses()
			->whereIn('id', $responseIds);
		$responses = $this->_sortResponses($responses);
		$tagResponsesUrl = $this->_routes->tagResponsesUrl();
		$sortingAction = $this->_routes->responsesTagsUrl($formId, $responseIds);

		$this->view
			->set('form', $form)
			->set('responses', $responses)
			->set('responseIds', $responseIds)
			->set('tagResponsesUrl', $tagResponsesUrl)
			->set('sortingAction', $sortingAction)
			->display();
  }

	/**
	 * Sort responses using given field and direction
	 *
	 * @param    object   $responses   Form's responses
	 * @return   void
	 */
	protected function _sortResponses($responses)
	{
		$sortDirection = $this->_params->getString('sort_direction', 'asc');
		$sortField = $this->_params->getString('sort_field', 'id');
		$sortingCriteria = ['field' => $sortField, 'direction' => $sortDirection];

		$this->view->set('sortingCriteria', $sortingCriteria);
		$sortableResponses = new SortableResponses(['responses' => $responses]);
		$sortableResponses->order($sortField, $sortDirection);

		return $sortableResponses;
	}

	/**
	 * Tag given responses
	 *
	 * @return   void
	 */
	public function tagTask()
	{
		$formId = $this->_params->getVar('form_id');
		$form = Form::oneOrFail($formId);

		$this->_bouncer->redirectUnlessCanEditForm($form);
		$this->_bouncer->redirectUnlessAuthorized('core.create');

		$responseIds = $this->_params->get('response_ids');
		$responses = $form->getResponses()
			->whereIn('id', $responseIds);
		$taggerId = User::get('id');
		$tagString = $this->_params->get('tags');

		$taggingResult = $this->_tagsHelper->addTags(
			$responses, $tagString, $taggerId
		);

		if ($taggingResult->succeeded())
		{
ddie('success');
			//$emailSentMessage = Lang::txt('COM_FORMS_EMAIL_SENT');
			//$responseList = $this->_routes->formsResponseList($formId);
			//$this->_vCrudHelper->successfulCreate($responseList, $emailSentMessage);
		}
		else
		{
ddie('failure');
			//$this->_bCrudHelper->failedCreate($email);
			//$this->setView('respondentemails', 'responses');
			//$this->responsesTask($email);
		}
	}

}
