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
require_once "$componentPath/helpers/params.php";
require_once "$componentPath/helpers/virtualCrudHelper.php";
require_once "$componentPath/models/formResponse.php";

use Components\Forms\Helpers\FormsRouter as RoutesHelper;
use Components\Forms\Helpers\Params;
use Components\Forms\Helpers\VirtualCrudHelper as VCrudHelper;
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
				'form_id' => $formId, 'order' => 1
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

}
