<?php
/*
 * @package   hubzero-cms
 * @copyright Copyright 2005-2015 HUBzero Foundation, LLC.
 * @license   http://opensource.org/licenses/MIT MIT
 */

namespace Components\Forms\Helpers;

$componentPath = Component::path('com_forms');

require_once "$componentPath/helpers/componentRouter.php";

class FormsRouter extends ComponentRouter
{

	/**
	 * Constructs FormsRouter instance
	 *
	 * @param    array   $args   Instantiation state
	 * @return   void
	 */
	public function __construct($args = [])
	{
		$args['base_segment'] = 'forms';

		parent::__construct($args);
	}

	/**
	 * Generates forms new URL
	 *
	 * @return   string
	 */
	public function formsNewUrl()
	{
		$segments = ['forms', 'new'];

		$url = $this->_generateComponentUrl($segments);

		return $url;
	}

	/**
	 * Generates forms create URL
	 *
	 * @return   string
	 */
	public function formsCreateUrl()
	{
		$segments = ['forms', 'create'];

		$url = $this->_generateComponentUrl($segments);

		return $url;
	}

	/**
	 * Generates forms edit URL
	 *
	 * @param    int      $formId   ID of form to edit
	 * @return   string
	 */
	public function formsEditUrl($formId)
	{
		$segments = ['forms', $formId, 'edit'];

		$url = $this->_generateComponentUrl($segments);

		return $url;
	}

	/**
	 * Generates forms edit URL
	 *
	 * @param    int      $formId   ID of form to edit
	 * @return   string
	 */
	public function formsUpdateUrl($formId)
	{
		$segments = ['forms', $formId, 'update'];

		$url = $this->_generateComponentUrl($segments);

		return $url;
	}

	/**
	 * Generates form list URL
	 *
	 * @return   string
	 */
	public function formListUrl()
	{
		$segments = ['forms', 'list'];

		$url = $this->_generateComponentUrl($segments);

		return $url;
	}

	/**
	 * Generates search update url
	 *
	 * @return   string
	 */
	public function queryUpdateUrl()
	{
		$segments = ['queries', 'update'];

		$url = $this->_generateComponentUrl($segments);

		return $url;
	}

	/**
	 * Generates form display url
	 *
	 * @param    int      $formId   ID of form to edit
	 * @return   string
	 */
	public function formsDisplayUrl($formId)
	{
		$segments = ['forms', $formId, 'display'];

		$url = $this->_generateComponentUrl($segments);

		return $url;
	}

	/**
	 * Generates form's pages list url
	 *
	 * @param    int      $formId   ID of form associated with pages
	 * @return   string
	 */
	public function formsPagesUrl($formId)
	{
		$segments = ['pages'];
		$parameters = ['form_id' => $formId];

		$url = $this->_generateComponentUrl($segments, $parameters);

		return $url;
	}

	/**
	 * Generates form's pages new url
	 *
	 * @param    int      $formId   ID of form associated with pages
	 * @return   string
	 */
	public function formsPagesNewUrl($formId)
	{
		$segments = ['pages', 'new'];
		$parameters = ['form_id' => $formId];

		$url = $this->_generateComponentUrl($segments, $parameters);

		return $url;
	}

	/**
	 * Generates form's pages create url
	 *
	 * @param    int      $formId   ID of form associated with pages
	 * @return   string
	 */
	public function formsPagesCreateUrl($formId)
	{
		$segments = ['pages', 'create'];
		$parameters = ['form_id' => $formId];

		$url = $this->_generateComponentUrl($segments, $parameters);

		return $url;
	}

	/**
	 * Generates page's edit url
	 *
	 * @param    int      $pageId   ID of page to edit
	 * @return   string
	 */
	public function pagesEditUrl($pageId)
	{
		$segments = ['pages', $pageId, 'edit'];

		$url = $this->_generateComponentUrl($segments);

		return $url;
	}

	/**
	 * Generates page's update url
	 *
	 * @param    int      $pageId   ID of page to update
	 * @return   string
	 */
	public function pagesUpdateUrl($pageId)
	{
		$segments = ['pages', $pageId, 'update'];

		$url = $this->_generateComponentUrl($segments);

		return $url;
	}

	/**
	 * Generates page's field editing url
	 *
	 * @param    int      $pageId   ID of page to edit fields of
	 * @return   string
	 */
	public function pagesFieldsEditUrl($pageId)
	{
		$segments = ['fields'];
		$parameters = ['page_id' => $pageId];

		$url = $this->_generateComponentUrl($segments, $parameters);

		return $url;
	}

	/**
	 * Generates form response start URL
	 *
	 * @param    int      $formId   ID of form user is starting on
	 * @return   string
	 */
	public function formResponseStartUrl($formId)
	{
		$segments = ['responses', 'start'];
		$parameters = ['form_id' => $formId];

		$url = $this->_generateComponentUrl($segments, $parameters);

		return $url;
	}

	/**
	 * Generates URL to page response page
	 *
	 * @param    int      $params   Query params
	 * @return   string
	 */
	public function formsPageResponseUrl($params)
	{
		$segments = ['fill'];

		$url = $this->_generateComponentUrl($segments, $params);

		return $url;
	}

	/**
	 * Generates URL to forms prereqs page
	 *
	 * @param    int      $formId   Form ID
	 * @return   string
	 */
	public function formsPrereqsUrl($formId)
	{
		$segments = ['steps'];
		$params = ['form_id' => $formId];

		$url = $this->_generateComponentUrl($segments, $params);

		return $url;
	}

	/**
	 * Generates URL to forms prereqs page
	 *
	 * @param    int      $prereqId   ID of prereq to edit
	 * @return   string
	 */
	public function prereqsEditUrl($prereqId)
	{
		$segments = ['steps', $prereqId, 'edit'];

		$url = $this->_generateComponentUrl($segments);

		return $url;
	}

	/**
	 * Generates form's prereqs new url
	 *
	 * @param    int      $formId   ID of form associated with pages
	 * @return   string
	 */
	public function formsPrereqsNewUrl($formId)
	{
		$segments = ['steps', 'new'];
		$parameters = ['form_id' => $formId];

		$url = $this->_generateComponentUrl($segments, $parameters);

		return $url;
	}

	/**
	 * Generates form's prereqs update url
	 *
	 * @param    int      $formId   ID of form to update prereqs for
	 * @return   string
	 */
	public function prereqsUpdateUrl($formId)
	{
		$segments = ['steps', 'update'];
		$parameters = ['form_id' => $formId];

		$url = $this->_generateComponentUrl($segments, $parameters);

		return $url;
	}

	/**
	 * Generates prereqs create url
	 *
	 * @return   string
	 */
	public function prereqsCreateUrl()
	{
		$segments = ['steps', 'create'];

		$url = $this->_generateComponentUrl($segments);

		return $url;
	}

	/**
	 *
	 *
	 */
	public function fieldsResponsesCreateUrl()
	{
		$segments = ['fill', 'create'];

		$url = $this->_generateComponentUrl($segments);

		return $url;
	}

	/**
	 * Generates form's prereqs update url
	 *
	 * @param    int      $formId   ID of form to update pages for
	 * @return   string
	 */
	public function batchPagesUpdateUrl()
	{
		$segments = ['pages', 'batchupdate'];

		$url = $this->_generateComponentUrl($segments);

		return $url;
	}

	/**
	 * Generates URL to form response review page
	 *
	 * @param    int      $formId   Given form's ID
	 * @return   string
	 */
	public function formResponseReviewUrl($formId)
	{
		$segments = ['responses', 'review'];
		$params = ['form_id' => $formId];

		$url = $this->_generateComponentUrl($segments, $params);

		return $url;
	}

	/**
	 * Generates form response submission URL
	 *
	 * @return   string
	 */
	public function formResponseSubmitUrl()
	{
		$segments = ['responses', 'submit'];

		$url = $this->_generateComponentUrl($segments);

		return $url;
	}

	/**
	 * Generates admin response review URL
	 *
	 * @param    int      $formId   Form ID
	 * @return   string
	 */
	public function formsResponseList($formId)
	{
		$params = ['form_id' => $formId];
		$segments = ['admin', 'responses'];

		$url = $this->_generateComponentUrl($segments, $params);

		return $url;
	}

	/**
	 * Generates URL to admin form response review page
	 *
	 * @param    int      $responseId   Given response's ID
	 * @return   string
	 */
	public function adminResponseReviewUrl($responseId)
	{
		$segments = ['admin', 'response'];
		$params = ['response_id' => $responseId];

		$url = $this->_generateComponentUrl($segments, $params);

		return $url;
	}

	/**
	 * Generates URL for given user's profile
	 *
	 * @param    int   $userId   Given user's ID
	 * @return   string
	 */
	public function userProfileUrl($userId)
	{
		$segments = ['members', $userId];

		$url = $this->_generateHubUrl($segments);

		return $url;
	}

	/**
	 * Generates URL to form response approval task
	 *
	 * @return   string
	 */
	public function responseApprovalUrl()
	{
		$segments = ['admin', 'response', 'approve'];

		$url = $this->_generateComponentUrl($segments);

		return $url;
	}

	/**
	 * Generates URL to user's responses list
	 *
	 * @return   string
	 */
	public function usersResponsesUrl()
	{
		$segments = ['responses', 'list'];

		$url = $this->_generateComponentUrl($segments);

		return $url;
	}

}
