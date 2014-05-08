<?php

namespace RegistryTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class AuthControllerTest extends AbstractHttpControllerTestCase
{
    protected $traceError = true;
    
    public function setUp()
    {
        $dir = __DIR__;
        $config = 'config/application.config.php';
        $this->setApplicationConfig(
            include $config
        );
        parent::setUp();
    }

    /**
     * @expectedException BjyAuthorize\Exception\UnAuthorizedException
     */
    public function testLoginActionAccess()
    {
    	$this->dispatch('/');

    	$this->assertRedirectTo('/user/login');
    }

    public function testLoginActionPostInvalid()
    {
    	$this->dispatch('/user/login', 'POST');

    	$this->assertResponseStatusCode(302);
    }
}
