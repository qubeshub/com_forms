<?php
/*
 * @package   hubzero-cms
 * @copyright Copyright 2005-2015 HUBzero Foundation, LLC.
 * @license   http://opensource.org/licenses/MIT MIT
 */

namespace Components\Forms\Helpers;

$componentPath = Component::path('com_forms');

require_once "$componentPath/helpers/emailFactory.php";

use Components\Forms\Helpers\EmailFactory;
use Hubzero\Utility\Arr;

class Email
{

	protected static $_requiredData = [
		'_title' => 'title',
		'_fromEmail' => 'from email',
		'_fromName' => 'from name',
		'_replyTo' => 'reply to',
		'_content' => 'content',
	 	'_to' => 'to'
	];

	/**
	 * Instantiates an Email object
	 *
	 * @return   void
	 */
	public function __construct($args = [])
	{
		$this->_title = $args['title'];
		$this->_fromEmail = Arr::getValue($args, 'from_email', Config::get('mail.mailfrom'));
		$this->_fromName = Arr::getValue($args, 'from_name', Config::get('mail.fromname'));
		$this->_replyTo = $args['reply_to'];
		$this->_content = $args['content'];
		$this->_to = $args['to'];
		$this->_emailFactory = Arr::getValue($args, 'factory', new EmailFactory());
		$this->_errors = [];
	}

	/**
	 * Sends email
	 *
	 * @return   void
	 */
	public function send()
	{
		$this->_setMessage();
		$this->_populateMessage();
		$this->_sendMessage();
	}

	/**
	 * Instantiates email message
	 *
	 * @return   void
	 */
	protected function _setMessage()
	{
		if (!isset($this->_message))
		{
			$this->_message = $this->_emailFactory->one();
		}
	}

	/**
	 * Getter for message
	 *
	 * @return   object
	 */
	protected function _getMessage()
	{
		if (!isset($this->_message))
		{
			$this->_setMessage();
		}

		return $this->_message;
	}

	/**
	 * Populates email message
	 *
	 * @return   void
	 */
	protected function _populateMessage()
	{
		$message = $this->_getMessage();
		$message->setSubject($this->_title);
		$message->addFrom($this->_fromEmail, $this->_fromName);
		$message->addPart($this->_content, 'text/plain');

		$this->_addReplyTo();
		$this->_addTo();
	}

	/**
	 * Adds reply to emails and names to the message
	 *
	 * @return   void
	 */
	protected function _addReplyTo()
	{
		foreach ($this->_replyTo as $i => $email)
		{
			$this->_getMessage()->addReplyTo($email);
		}
	}

	/**
	 * Adds to emails and names to the message
	 *
	 * @return   void
	 *
	 */
	protected function _addTo()
	{
		foreach ($this->_to as $i => $email)
		{
			$this->_getMessage()->addTo($email);
		}
	}

	/**
	 * Sends email
	 *
	 * @return   void
	 */
	protected function _sendMessage()
	{
		$message = $this->_getMessage();

		if ($this->isValid())
		{
			$message->send();
		}
	}

	/**
	 * Indicates if email is valid
	 *
	 * @return   bool
	 */
	public function isValid()
	{
		$isValid = true;

		foreach (self::_getRequiredData() as $attribute)
		{
			if (empty($this->$attribute))
			{
				$isValid = false;
				$this->_addNonEmptyError($attribute);
			}
		}

		return $isValid;
	}

	/**
	 * Adds empty attribute error
	 *
	 * @return   void
	 */
	protected function _addNonEmptyError($attribute)
	{
		$nonEmptyError = Lang::txt('COM_FORMS_EMAIL_NON_EMPTY');
		$attributeName = self::_getAttributeName($attribute);

		$this->_addError("$attributeName $nonEmptyError");
	}

	/**
	 * Adds message to errors
	 *
	 * @return   bool
	 */
	protected function _addError($error)
	{
		$this->_errors[] = $error;
	}

	/**
	 * Returns copy of instance's errors
	 *
	 * @return   array
	 */
	public function getErrors()
	{
		$this->isValid();

		return $this->_errors;
	}

	/**
	 * Indicates if email was sent to all recipients successfully
	 *
	 * @return   bool
	 */
	public function sentSuccessfully()
	{
		$failures = $this->_getMessage()->getFailures();
		$isValid = $this->isValid();

		return $isValid && empty($failures);
	}

	/**
	 * Forwards function invocation to $this->_message
	 *
	 * @return   mixed
	 */
	public function __call($name, $args)
	{
		$message = $this->_getMessage();

		return $message->$name(...$args);
	}

	/**
	 * Returns names of required attributes
	 *
	 * @return   array
	 */
	protected static function _getRequiredData()
	{
		return array_keys(self::$_requiredData);
	}

	/**
	 * Returns user-friendly name of attribute
	 *
	 * @param    string   $attribute   Local attribute name
	 * @return   string
	 */
	protected static function _getAttributeName($attribute)
	{
		return self::$_requiredData[$attribute];
	}

}
