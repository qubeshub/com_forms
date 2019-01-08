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

namespace Components\Forms\Api\Controllers;

$componentPath = Component::path('com_forms');

require_once "$componentPath/helpers/apiResponseFactory.php";
require_once "$componentPath/helpers/pageBouncer.php";
require_once "$componentPath/helpers/pageFieldsFactory.php";
require_once "$componentPath/helpers/params.php";
require_once "$componentPath/models/formPage.php";

use Components\Forms\Helpers\ApiResponseFactory;
use Components\Forms\Helpers\PageBouncer;
use Components\Forms\Helpers\PageFieldsFactory;
use Components\Forms\Helpers\Params;
use Components\Forms\Models\FormPage;
use Hubzero\Component\ApiController;

class PageFieldsv1_0 extends ApiController
{

	/**
	 * Controller version
	 *
	 * @var  string
	 */
	protected static $version = '1.0';

	/**
	 * Parameter whitelist
	 *
	 * @var  array
	 */
	protected static $_paramWhitelist = [
		'fields',
		'page_id'
	];

	/**
	 * Executes the requested task
	 *
	 * @return   void
	 */
	public function execute()
	{
		$this->_apiResponseFactory = new ApiResponseFactory();
		$this->_bouncer = new PageBouncer([
			'component' => $this->_option
		]);
		$this->_factory = new PageFieldsFactory();
		$this->_params = new Params([
			'whitelist' => self::$_paramWhitelist
		]);

		parent::execute();
	}

	/**
	 * Retrieve fields based on page ID
	 *
	 * @apiMethod GET
	 * @apiUri    /api/v1.0/forms/pagefields/getByPage
	 * @apiParameter {
	 * 		"name":          page_id,
	 * 		"description":   Page ID,
	 * 		"type":          int,
	 * 		"required":      true
	 * }
	 * @return   object
	 */
	public function getByPageTask()
	{
		$this->requiresAuthentication();
		$this->_bouncer->redirectUnlessAuthorized('core.create');

		$pageId = $this->_params->get('page_id');
		$page = FormPage::one($pageId);

		$readResult = $this->_factory->readPagesFields($page);

		$response = $this->_apiResponseFactory->one([
			'operation' => 'read',
		 	'result' => $readResult,
			'error_message' => Lang::txt('COM_FORMS_FIELDS_READ_ERROR'),
			'success_message' => Lang::txt('COM_FORMS_FIELDS_READ_SUCCESS')
		]);

		$this->send($response->toArray());
	}

	/**
	 * Update page's fields using provided data
	 *
	 * @apiMethod POST
	 * @apiUri    /api/v1.0/forms/pagefields/update
	 * @apiParameter {
	 * 		"name":          page_id,
	 * 		"description":   Page ID,
	 * 		"type":          int,
	 * 		"required":      true
	 * }
	 * @apiParameter {
	 * 		"name":          fields,
	 * 		"description":   fields' data,
	 * 		"type":          array,
	 * 		"required":      true
	 * }
	 * @return   object
	 */
	public function updateTask()
	{
		//$this->requiresAuthentication();
		$this->_bouncer->redirectUnlessAuthorized('core.create');

		$pageId = $this->_params->get('page_id');
		$page = FormPage::oneOrNew($pageId);
		$pageIsNew = $page->isNew();
		$userCanEditPage = $page->editableBy(User::getCurrentUser());

		if (!$pageIsNew && $userCanEditPage)
		{
			$response = $this->_updatePagesFields($page);
		}
		else
		{
			$response = $this->_updatePagesFieldsIssue($pageIsNew, $userCanEditPage);
		}

		$this->send($response->toArray());
	}

	/**
	 * Attempts to update given pages fields
	 *
	 * @param    object   $page   Page record
	 * @return   object
	 */
	protected function _updatePagesFields($page)
	{
		$newFieldsData = $this->_params->get('fields');
		$pagesFields = $page->getFieldsInArray();
		$updateResult = $this->_factory->updatePagesFields($pagesFields, $newFieldsData);
		$response = $this->_apiResponseFactory->one([
			'operation' => 'batchUpdate',
			'result' => $updateResult,
			'error_message' => Lang::txt('COM_FORMS_FIELDS_UPDATE_ERROR'),
			'success_message' => Lang::txt('COM_FORMS_FIELDS_UPDATE_SUCCESS')
		]);

		return $response;
	}

	/**
	 * Generates response when issues prevent update
	 *
	 * @param    bool     $pageIsNew         Indicates if Page record is new
	 * @param    bool     $userCanEditPage   Indicates if current user can edit page
	 * @return   object
	 */
	protected function _updatePagesFieldsIssue($pageIsNew, $userCanEditPage)
	{
		$message = $this->_updatePagesFieldsIssueMessage($pageIsNew, $userCanEditPage);

		$response = $this->_apiResponseFactory->one([
			'operation' => 'null',
			'message' =>  $message,
			'status' => 'error',
		]);

		return $response;
	}

	/**
	 * Generates response message when issues prevent update
	 *
	 * @param    bool     $pageIsNew         Indicates if Page record is new
	 * @param    bool     $userCanEditPage   Indicates if current user can edit page
	 * @return   object
	 */
	protected function _updatePagesFieldsIssueMessage($pageIsNew, $userCanEditPage)
	{
		if ($pageIsNew)
		{
			$message = Lang::txt('COM_FORMS_FIELDS_UPDATE_NO_PAGE_RECORD');
		}
		else
		{
			$message = Lang::txt('COM_FORMS_FIELDS_UPDATE_PERMISSIONS_DENIED');
		}

		return $message;
	}

}
