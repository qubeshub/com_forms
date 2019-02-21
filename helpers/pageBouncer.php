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
 * @author    Anthony Fuentes <fuentesa@purdue.edu>
 * @copyright Copyright 2005-2015 HUBzero Foundation, LLC.
 * @license   http://opensource.org/licenses/MIT MIT
 */

namespace Components\Forms\Helpers;

$componentPath = Component::path('com_forms');

require_once "$componentPath/helpers/formsAuth.php";
require_once "$componentPath/helpers/mockProxy.php";

use Components\Forms\Helpers\FormsAuth;
use Components\Forms\Helpers\MockProxy;
use Hubzero\Utility\Arr;

class PageBouncer
{

	protected $_permitter,	$_router;

	/**
	 * Constructs PageBouncer instance
	 *
	 * @param    array   $args   Instantiation state
	 * @return   void
	 */
	public function __construct($args = [])
	{
		$this->_permitter = Arr::getValue($args, 'permitter', new FormsAuth());
		$this->_router = Arr::getValue($args, 'router', new MockProxy(['class' => 'App']));
	}

	/**
	 * Redirects user if they cannot edit given form
	 *
	 * @param    object   $form   Form record
	 * @param    string   $url    URL to redirect to
	 * @return   void
	 */
	public function redirectUnlessCanEditForm($form, $url = null)
	{
		$url = $url ? $url : '/forms';

		$this->redirectUnlessAuthorized('core.create', $url);

		$canEdit = $this->_permitter->canCurrentUserEditForm($form);

		if (!$canEdit)
		{
			$this->_router->redirect($url);
		}
	}

	/**
	 * Redirects user if the form is disabled
	 *
	 * @param    object   $form   Form record
	 * @param    string   $url    URL to redirect to
	 * @return   void
	 */
	public function redirectIfFormDisabled($form, $url = null)
	{
		$url = $url ? $url : '/forms';

		if ($form->get('disabled'))
		{
			$this->_router->redirect($url);
		}
	}

	/**
	 * Redirects user if form response has been submitted
	 *
	 * @param    object   $response   Form response
	 * @param    string   $url    URL to redirect to
	 * @return   void
	 */
	public function redirectIfResponseSubmitted($response, $url = '/forms')
	{
		$url = $url ? $url : '/forms';

		if ($response->get('submitted'))
		{
			$this->_router->redirect($url);
		}
	}

	/**
	 * Redirects users without given permission
	 *
	 * @param    string   $permission   Permission name
	 * @return   void
	 */
	public function redirectUnlessAuthorized($permission, $url = '/')
	{
		$isAuthorized = $this->_permitter->currentIsAuthorized($permission);

		if (!$isAuthorized)
		{
			$this->_router->redirect($url);
		}
	}

}
