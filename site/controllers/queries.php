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

require_once "$componentPath/helpers/componentRouter.php";
require_once "$componentPath/helpers/mockProxy.php";
require_once "$componentPath/helpers/pageBouncer.php";
require_once "$componentPath/helpers/params.php";
require_once "$componentPath/helpers/query.php";
require_once "$componentPath/helpers/virtualCrudHelper.php";

use Components\Forms\Helpers\FormsRouter as RoutesHelper;
use Components\Forms\Helpers\MockProxy;
use Components\Forms\Helpers\PageBouncer;
use Components\Forms\Helpers\Params;
use Components\Forms\Helpers\Query;
use Components\Forms\Helpers\VirtualCrudHelper as CrudHelper;
use Hubzero\Component\SiteController;
use Hubzero\Utility\Arr;

class Queries extends SiteController
{

	/**
	 * Task mapping
	 *
	 * @var  array
	 */
	protected $_taskMap = [
		'__default' => 'update'
	];

	/**
	 * Parameter whitelist
	 *
	 * @var  array
	 */
	protected static $_paramWhitelist = [
		'archived',
		'fuzzy_end',
		'name',
		'closing_time',
		'closing_time_relative_operator',
		'disabled',
		'opening_time',
		'opening_time_relative_operator',
		'responses_locked',
	];

	/**
	 * Executes the requested task
	 *
	 * @return   void
	 */
	public function execute()
	{
		$this->bouncer = new PageBouncer([
			'component' => $this->_option
		]);
		$this->crudHelper = new CrudHelper([
			'errorSummary' => Lang::txt('COM_FORMS_QUERY_UPDATE_ERROR')
		]);
		$this->params = new Params(
			['whitelist' => self::$_paramWhitelist]
		);
		$this->router = new MockProxy(['class' => 'App']);
		$this->routes = new RoutesHelper();

		parent::execute();
	}

	/**
	 * Updates search query
	 *
	 * @return   void
	 */
	public function updateTask()
	{
		Request::checkToken();
		$this->bouncer->redirectUnlessAuthorized('core.create');

		$forwardingUrl = $this->routes->formListUrl();
		$queryData = $this->_getNonEmptyCriteria();

		$query = new Query();
		$query->setAssociative($queryData);

		if ($query->save())
		{
			$this->crudHelper->successfulCreate($forwardingUrl);
		}
		else
		{
			$this->crudHelper->failedCreate($query, $forwardingUrl);
		}
	}

	/**
	 * Filters out criteria without operator or value data
	 *
	 * @return
	 */
	protected function _getNonEmptyCriteria()
	{
		$criteria = $this->params->get('query');

		$filteredCriteria = array_filter($criteria, function($criterion) use($criteria) {
			$operatorPresent = $criterion['operator'] !== '';
			$valuePresent = $criterion['value'] !== '';

			return $operatorPresent && $valuePresent;
		});

		return $filteredCriteria;
	}

}
