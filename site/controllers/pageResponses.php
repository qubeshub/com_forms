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

require_once "$componentPath/helpers/params.php";
require_once "$componentPath/models/form.php";
require_once "$componentPath/models/formPage.php";

use Components\Forms\Helpers\Params;
use Components\Forms\Models\Form;
use Components\Forms\Models\FormPage;
use Hubzero\Component\SiteController;

class PageResponses extends SiteController
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
		$this->_params = new Params(
			['whitelist' => self::$_paramWhitelist]
		);

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

		$this->view
			->set('form', $this->_form)
			->set('page', $this->_page)
			->display();
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