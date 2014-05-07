<?php

namespace RegistryTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Zend\Session\Container;

class GroupControllerTest extends AbstractHttpControllerTestCase
{
    protected $traceError = true;
    
    public function setUp()
    {
        $dir = __DIR__;
        $config = 'config/application.config.php';
        // Zend Studio
        //$config = '../../../config/application.config.php';
        $this->setApplicationConfig(
            include $config
        );
        parent::setUp();
        $this->mockAuth();
    }

    /**
     * Crea un mock de autenticacion con un usuario administrador
     */
    public function mockAuth($admin = true)
    {
        $serviceManager = $this->getApplicationServiceLocator();
        $objectManager = $serviceManager->get('doctrine.entitymanager.orm_default');
        
        $user = $objectManager->find('Registry\Entity\User', 1);
            
        $authMock = $this->getMockBuilder('ZfcUser\Controller\Plugin\ZfcUserAuthentication')->disableOriginalConstructor()->getMock();
        $authMock->expects($this->any())->method('hasIdentity')->will($this->returnValue(true));
        $authMock->expects($this->any())->method('getIdentity')->will($this->returnValue($user));
        
        $authServiceMock = $this->getMockBuilder('Zend\Authentication\AuthenticationService')->disableOriginalConstructor()->getMock();
        $authServiceMock->expects($this->any())->method('hasIdentity')->will($this->returnValue(true));
        $authServiceMock->expects($this->any())->method('getIdentity')->will($this->returnValue($user));
        
        // Creating mock
        $mockBjy = $this->getMockBuilder('BjyAuthorize\Service\Authorize')->disableOriginalConstructor()->getMock();
        $mockBjy->expects($this->any())->method('isAllowed')->will($this->returnValue(true));
        
        $serviceManager->setAllowOverride(true);
        $serviceManager->setService('zfcuser_auth_service', $authServiceMock);
        $serviceManager->setService('BjyAuthorize\Service\Authorize', $mockBjy);
        $serviceManager->setService('ZfcUser\Controller\Plugin\ZfcUserAuthentication', $authMock);
        $serviceManager->get('Zend\Mvc\Controller\PluginManager')->setService('zfcUserAuthentication', $authMock);
    }

    public function testIndexActionAccess()
    {
        $this->dispatch('/groups');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('Registry');
        $this->assertControllerName('Registry\Controller\Group');
        $this->assertControllerClass('GroupController');
        $this->assertMatchedRouteName('groups');

        $this->assertQueryCountMin('table.table tbody tr', 2);
    }

    public function testCreateActionCanAccess()
    {
        $this->dispatch('/groups/create');

        $this->assertResponseStatusCode(200);
        $this->assertControllerName('Registry\Controller\Group');
        $this->assertMatchedRouteName('groups/default');
        $this->assertActionName('create');
    }

    public function testCreateActionPRG()
    {
        $this->dispatch('/groups/create', 'POST', array());

        $this->assertResponseStatusCode(303);
    }

    public function testCreateActionInvalidForm()
    {
        $post = new Container('prg_post1');
        $post->post = array();

        $csrf = new \Zend\Session\Container('Zend_Validator_Csrf_salt_formcsrf');
        $csrf->hash = 'testhash';

        $this->dispatch('/groups/create');

        $this->assertResponseStatusCode(200);
        $this->assertQuery('.has-error');
    }
}
