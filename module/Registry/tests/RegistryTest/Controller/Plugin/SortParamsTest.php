<?php
namespace RegistryTest\Controller\Plugin;

use PHPUnit_Framework_TestCase;
use Registry\Mvc\Controller\Plugin\SortParams;

class SortParamsTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @expectedException Exception
	 */
	public function testInvoke()
	{
		$plugin = new SortParams();
		$plugin->__invoke('dummy');
	}
}
