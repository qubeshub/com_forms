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

namespace Components\Forms\Tests;

$componentPath = Component::path('com_forms');

require_once "$componentPath/helpers/factory.php";
require_once "$componentPath/tests/helpers/canMock.php";

use Hubzero\Test\Basic;
use Components\Forms\Helpers\Factory;
use Components\Forms\Tests\Traits\canMock;

class FactoryTest extends Basic
{
	use canMock;

	public function testInstantiateInstantiatesModelOfGivenClass()
	{
		$instance = $this->mock([
			'class' => 'RelationalInstance', 'methods' => ['set']
		]);
		$modelClass = $this->mock([
			'class' => 'Relational', 'methods' => ['blank' => $instance]
		]);
		$factory = new Factory([
			'model_class' => $modelClass,
			'model_name' => ''
		]);

		$model = $factory->instantiate();

		$this->assertEquals($instance, $model);
	}

	public function testInstantiateManyReturnsEmptyArrayWhenGivenEmptyArray()
	{
		$factory = new Factory([
			'model_class' => '',
			'model_name' => ''
		]);

		$models = $factory->instantiateMany([]);

		$this->assertEquals([], $models);
	}

	public function testInstantiateManyReturnsModelInstancesWhenGivenData()
	{
		$instance = $this->mock([
			'class' => 'RelationalInstance', 'methods' => ['set']
		]);
		$modelClass = $this->mock([
			'class' => 'Relational', 'methods' => ['blank' => $instance]
		]);
		$factory = new Factory([
			'model_class' => $modelClass,
			'model_name' => ''
		]);

		$models = $factory->instantiateMany([[], [], []]);

		$this->assertEquals([$instance, $instance, $instance], $models);
	}

	public function testInstantiateReturnsModelInstance()
	{
		$instance = $this->mock([
			'class' => 'RelationalInstance', 'methods' => ['set']
		]);
		$modelClass = $this->mock([
			'class' => 'Relational', 'methods' => ['blank' => $instance]
		]);
		$factory = new Factory([
			'model_class' => $modelClass,
			'model_name' => ''
		]);

		$model = $factory->instantiate();

		$this->assertEquals($instance, $model);
	}

}
