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

require_once "$componentPath/helpers/formsAuth.php";
require_once "$componentPath/helpers/listErrorMessage.php";
require_once "$componentPath/helpers/params.php";
require_once "$componentPath/models/form.php";
require_once "$componentPath/models/formPrerequisite.php";

use Components\Forms\Helpers\FormsAuth;
use Components\Forms\Helpers\ListErrorMessage as ErrorMessage;
use Components\Forms\Helpers\Params;
use Components\Forms\Models\Form;
use Components\Forms\Models\FormPrerequisite;
use Hubzero\Component\ApiController;

class FormPrerequisitesv1_0 extends ApiController
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
		'id'
	];

	/**
	 * Executes the requested task
	 *
	 * @return   void
	 */
	public function execute()
	{
		$this->_auth = new FormsAuth();
		$this->_params = new Params([
			'whitelist' => self::$_paramWhitelist
		]);

		parent::execute();
	}

	/**
	 * Attempts to destroy FormPrerequisite with given ID
	 *
	 * @apiMethod DELETE
	 * @apiUri    /api/v1.0/forms/formprerequisites/destroy
	 * @apiParameter {
	 * 		"name":          id,
	 * 		"description":   FormPrerequisite ID,
	 * 		"type":          int,
	 * 		"required":      true
	 * }
	 * @return   object
	 */
	public function destroyTask()
	{
		$this->requiresAuthentication();

		$prereqId = $this->_params->getInt('id');
		$prereq = FormPrerequisite::oneOrFail($prereqId);
		$form = $prereq->getForm();

		$canEdit = $this->_auth->canCurrentUserEditForm($form);

		if (!$canEdit)
		{
			$status = 'error';
			$message = Lang::txt('COM_FORMS_STEPS_FAILED_DESTROY_PERMISSION');
		}
		elseif ($prereq->destroy())
		{
			$status = 'success';
			$message = Lang::txt('COM_FORMS_STEPS_SUCCESSFUL_DESTROY');
		}
		else
		{
			$status = 'error';
			$message = $this->_generateDestroyErrorMessage($prereq->getErrors());
		}

		$this->send([
			'status' => $status,
			'message' => $message
		]);
	}

	/**
	 * Generates failed destroy error message
	 *
	 * @param    array    $errors   Record's errors
	 * @return   string
	 */
	protected function _generateDestroyErrorMessage($errors)
	{
		$errorIntro = Lang::txt('COM_FORMS_STEPS_FAILED_DESTROY');

		$errorMessage = $this->_generateErrorMessage($errors, $errorIntro);

		return $errorMessage;
	}

	/**
	 * Generates error message
	 *
	 * @param    array     $errors       Record's errors
	 * @param    string    $errorIntro   Top-level error text
	 * @return   string
	 */
	protected function _generateErrorMessage($errors, $errorIntro = '')
	{
		$messageObject = new ErrorMessage([
			'errorIntro' => $errorIntro,
			'errors' => $errors
		]);

		return $messageObject->toString();
	}

}
