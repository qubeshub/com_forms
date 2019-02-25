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

require_once "$componentPath/helpers/formsRouter.php";
require_once "$componentPath/helpers/pageBouncer.php";
require_once "$componentPath/helpers/params.php";
require_once "$componentPath/models/form.php";

use Components\Forms\Helpers\FormsRouter as RoutesHelper;
use Components\Forms\Helpers\PageBouncer;
use Components\Forms\Helpers\Params;
use Components\Forms\Models\Form;
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
		$this->_params = new Params(
			['whitelist' => self::$_paramWhitelist]
		);
		$this->_routes = new RoutesHelper();

		parent::execute();
	}

	/**
	 * Renders list of reviews for given form
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

}
