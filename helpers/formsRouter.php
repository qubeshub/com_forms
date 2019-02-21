<?php
/*
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

require_once "$componentPath/helpers/urlBuilder.php";

class FormsRouter
{

	protected $_baseSegment, $_urlBuilder;

	/**
	 * Constructs ComponentRouter instance
	 *
	 * @param    array   $args   Instantiation state
	 * @return   void
	 */
	public function __construct($args = [])
	{
		$this->_urlBuilder = new UrlBuilder();
		$this->_baseSegment = 'forms';
	}

	/**
	 * Generates forms new URL
	 *
	 * @return   string
	 */
	public function formsNewUrl()
	{
		$segments = ['forms', 'new'];

		$url = $this->_generateUrl($segments);

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

		$url = $this->_generateUrl($segments);

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

		$url = $this->_generateUrl($segments);

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

		$url = $this->_generateUrl($segments);

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

		$url = $this->_generateUrl($segments);

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

		$url = $this->_generateUrl($segments);

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

		$url = $this->_generateUrl($segments);

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

		$url = $this->_generateUrl($segments, $parameters);

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

		$url = $this->_generateUrl($segments, $parameters);

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

		$url = $this->_generateUrl($segments, $parameters);

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

		$url = $this->_generateUrl($segments);

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

		$url = $this->_generateUrl($segments);

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

		$url = $this->_generateUrl($segments, $parameters);

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

		$url = $this->_generateUrl($segments, $parameters);

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

		$url = $this->_generateUrl($segments, $params);

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

		$url = $this->_generateUrl($segments, $params);

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

		$url = $this->_generateUrl($segments);

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

		$url = $this->_generateUrl($segments, $parameters);

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

		$url = $this->_generateUrl($segments, $parameters);

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

		$url = $this->_generateUrl($segments);

		return $url;
	}

	/**
	 *
	 *
	 */
	public function fieldsResponsesCreateUrl()
	{
		$segments = ['fill', 'create'];

		$url = $this->_generateUrl($segments);

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

		$url = $this->_generateUrl($segments);

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
		$segments = ['fill', 'review'];
		$params = ['form_id' => $formId];

		$url = $this->_generateUrl($segments, $params);

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

		$url = $this->_generateUrl($segments);

		return $url;
	}

	/**
	 * Generates URL based on given segments and parameters
	 *
	 * @param    array    $segments     URL segments
	 * @param    array    $parameters   URL parameters
	 * @return   string
	 */
	protected function _generateUrl($segments, $parameters = [])
	{
		array_unshift($segments, $this->_baseSegment);

		$url = $this->_urlBuilder->generateUrl($segments, $parameters);

		return $url;
	}

}
