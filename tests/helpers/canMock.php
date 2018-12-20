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

namespace Components\Forms\Tests\Traits;

use Hubzero\Utility\Arr;
use Hubzero\Test\Basic;

trait canMock
{

	public function	mock($args = [])
	{
		$this->mock = $this->getMockBuilder($args['class']);

		$this->_setMethods($args);
		$this->_setProps($args);

		return $this->mock;
	}

	protected function _setProps($args)
	{
		$props = $this->_extractMockInstantiationData($args, 'props');

		$this->_setPropNamesAndValues($props);
	}

	protected function _setPropNamesAndValues($props)
	{
		foreach ($props as $name => $value)
		{
			$this->mock->$name = $value;
		}
	}

	protected function _setMethods($args)
	{
		$methods = $this->_extractMockInstantiationData($args, 'methods');

		$this->_setMethodNames($methods);
		$this->_setMethodReturnValues($methods);
	}

	protected function _extractMockInstantiationData($args, $key)
	{
		$instantiationData = Arr::getValue($args, $key, []);

		$instantiationData = $this->_mapInstantiationData($instantiationData);

		return $instantiationData;
	}

	protected function _mapInstantiationData($instantiationData)
	{
		$mappedInstantiationData = [];

		foreach ($instantiationData as $name => $value)
		{
			$this->_mapNameAndValue($mappedInstantiationData, $name, $value);
		}

		return $mappedInstantiationData;
	}

	protected function _mapNameAndValue(&$mappedInstantiationData, $name, $value)
	{
		if (!is_string($name))
		{
			$mappedInstantiationData[$value] = null;
		}
		else
		{
			$mappedInstantiationData[$name] = $value;
		}
	}

	protected function _setMethodNames($methods)
	{
		$methodNames = array_keys($methods);

		$this->mock->setMethods($methodNames);

		$this->mock = $this->mock->getMock();
	}

	protected function _setMethodReturnValues($methods)
	{
		foreach ($methods as $name => $returnValue)
		{
			$this->mock->method($name)->willReturn($returnValue);
		}
	}

}
