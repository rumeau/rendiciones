<?php
namespace RegistryTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Zend\Session\Container;
use Zend\Crypt\Password\Bcrypt;

class UserControllerTest extends AbstractHttpControllerTestCase
{
    protected $traceError = true;

    protected static $dummyUser;
    
    public function setUp()
    {
        $config = 'config/application.config.php';
        $this->setApplicationConfig(
            include $config
        );
        parent::setUp();
        $this->mockAuth();
    }

    /**
     * Crea un mock de autenticacion con un usuario administrador
     */
    public function mockAuth()
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
        $this->dispatch('/users');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('Registry');
        $this->assertControllerName('Registry\Controller\User');
        $this->assertControllerClass('UserController');
        $this->assertMatchedRouteName('users');

        $this->assertQueryCountMin('table.table tbody tr', 2);
    }

    public function testIndexActionWithParams()
    {
        $this->dispatch('/users?sort=desc&by=identity&filter=2');

        $this->assertQueryCountMin('table.table tbody tr p.text-muted', 1);
    }

    public function testCreateActionGet()
    {
        $serviceManager = $this->getApplicationServiceLocator();
        $objectManager = $serviceManager->get('doctrine.entitymanager.orm_default');
        $user = $objectManager->getRepository('Registry\Entity\User')->findOneBy(array('identity' => '999999999'));
        if (is_object($user)) {
            $this->markTestIncomplete('Ya existe un usuario DUMMY, no se puede probar');
        }

        $this->dispatch('/users/create');

        $this->assertResponseStatusCode(200);
    }

    public function testCreateActionPRG()
    {
        $this->dispatch('/users/create', 'POST', array());

        $this->assertResponseStatusCode(303);
    }

    public function testCreateActionInvalidForm()
    {
        $post = new Container('prg_post1');
        $post->post = array(
            'formcsrf' => 'testhash',
            'user' => array()
        );

        $csrf = new Container('Zend_Validator_Csrf_salt_formcsrf');
        $csrf->hash = 'testhash';

        $this->dispatch('/users/create');

        $this->assertResponseStatusCode(200);
    }

    public function testCreateActionValidForm()
    {
        $post = new Container('prg_post1');
        $post->post = array(
            'formcsrf' => 'testhash',
            'user' => array(
                'name' => 'TESTUSER',
                'identity' => '999999999',
                'password_n' => 'dummypass',
                'password_c' => 'dummypass',
                'email' => 'demo@example.com',
                'userGroup' => '1',
                'workPhone' => '',
                'homePhone' => '',
                'mobilePhone' => '',
                'address' => 'TESTADDRESS',
                'userRoles' => array('1','2','3'),
                'moderatedGroups' => array('6')
            )
        );

        $csrf = new Container('Zend_Validator_Csrf_salt_formcsrf');
        $csrf->hash = 'testhash';

        $this->dispatch('/users/create');

        $this->assertResponseStatusCode(302);

        $serviceManager = $this->getApplicationServiceLocator();
        $objectManager = $serviceManager->get('doctrine.entitymanager.orm_default');
        $user = $objectManager->getRepository('Registry\Entity\User')->findOneBy(array('identity' => '999999999'));

        $this->assertInstanceOf('Registry\Entity\User', $user);

    }

    public function testEditActionCantAccess()
    {
        $this->dispatch('/users/edit?id=20000');

        $this->assertResponseStatusCode(302);
    }

    public function testEditActionAccess()
    {
        $serviceManager = $this->getApplicationServiceLocator();
        $objectManager = $serviceManager->get('doctrine.entitymanager.orm_default');
        self::$dummyUser = $objectManager->getRepository('Registry\Entity\User')->findOneBy(array('identity' => '999999999'));
        if (!is_object(self::$dummyUser)) {
            $this->markTestIncomplete('No se encontro el usuario DUMMY para correr los tests');
        }

        $this->dispatch('/users/edit?id=' . self::$dummyUser->getId());

        $this->assertResponseStatusCode(200);
    }

    /**
     * @depends testEditActionAccess
     */
    public function testEditActionPRG()
    {
        $this->dispatch('/users/edit?id=' . self::$dummyUser->getId(), 'POST', array());

        $this->assertResponseStatusCode(303);
    }

    /**
     * @depends testEditActionAccess
     */
    public function testEditActionInvalidForm()
    {
        $post = new Container('prg_post1');
        $post->post = array(
            'formcsrf' => 'testhash',
            'user' => array()
        );

        $csrf = new Container('Zend_Validator_Csrf_salt_formcsrf');
        $csrf->hash = 'testhash';

        $this->dispatch('/users/edit?id=' . self::$dummyUser->getId());

        $this->assertResponseStatusCode(200);

    }

    /**
     * @depends testEditActionAccess
     */
    public function testEditActionValidForm()
    {
        $post = new Container('prg_post1');
        $post->post = array(
            'formcsrf' => 'testhash',
            'user' => array(
                'name' => 'TESTUSEREDITED',
                'status' => 1,
                'password_n' => 'passedited',
                'password_c' => 'passedited',
                'password_o' => 'dummypass',
                'email' => 'demo@example.com',
                'userGroup' => '1',
                'workPhone' => '',
                'homePhone' => '',
                'mobilePhone' => '',
                'address' => 'TESTADDRESS',
                'userRoles' => array('1','2','3'),
                'moderatedGroups' => array('6')
            )
        );

        $csrf = new Container('Zend_Validator_Csrf_salt_formcsrf');
        $csrf->hash = 'testhash';

        $this->dispatch('/users/edit?id=' . self::$dummyUser->getId());

        $this->assertResponseStatusCode(302);
        $serviceManager = $this->getApplicationServiceLocator();
        $objectManager = $serviceManager->get('doctrine.entitymanager.orm_default');
        $user = $objectManager->getRepository('Registry\Entity\User')->findOneBy(array('identity' => '999999999'));
        
        $this->assertEquals('TESTUSEREDITED', $user->getName());

        $bcrypt = new Bcrypt();
        $authService = $serviceManager->get('zfcuser_user_service');
        $bcrypt->setCost($authService->getOptions()->getPasswordCost());
        $this->assertTrue($bcrypt->verify('passedited', $user->getCredential()));
    }

    /**
     * @depends testEditActionAccess
     */
    public function testEditActionValidFormDeactivate()
    {
        $post = new Container('prg_post1');
        $post->post = array(
            'formcsrf' => 'testhash',
            'user' => array(
                'name' => 'TESTUSEREDITED',
                'status' => 2,
                'password_n' => '',
                'password_c' => '',
                'password_o' => '',
                'email' => 'demo@example.com',
                'userGroup' => '1',
                'workPhone' => '',
                'homePhone' => '',
                'mobilePhone' => '',
                'address' => 'TESTADDRESS',
                'userRoles' => array('1','2','3'),
                'moderatedGroups' => array('6')
            )
        );

        $csrf = new Container('Zend_Validator_Csrf_salt_formcsrf');
        $csrf->hash = 'testhash';

        $this->dispatch('/users/edit?id=' . self::$dummyUser->getId());

        $this->assertResponseStatusCode(302);
        $serviceManager = $this->getApplicationServiceLocator();
        $objectManager = $serviceManager->get('doctrine.entitymanager.orm_default');
        $user = $objectManager->getRepository('Registry\Entity\User')->findOneBy(array('identity' => '999999999'));
        
        $this->assertEquals(2, $user->getStatus());
    }

    /**
     * @depends testEditActionAccess
     */
    public function testEditActionValidFormReactivate()
    {
        $post = new Container('prg_post1');
        $post->post = array(
            'formcsrf' => 'testhash',
            'user' => array(
                'name' => 'TESTUSEREDITED',
                'status' => 1,
                'password_n' => 'dummypass',
                'password_c' => 'dummypass',
                'password_o' => 'passeditedfalse',
                'email' => 'demo@example.com',
                'userGroup' => '1',
                'workPhone' => '',
                'homePhone' => '',
                'mobilePhone' => '',
                'address' => 'TESTADDRESS',
                'userRoles' => array('1','2','3'),
                'moderatedGroups' => array('6')
            )
        );

        $csrf = new Container('Zend_Validator_Csrf_salt_formcsrf');
        $csrf->hash = 'testhash';

        $this->dispatch('/users/edit?id=' . self::$dummyUser->getId());

        $this->assertResponseStatusCode(302);
        $serviceManager = $this->getApplicationServiceLocator();
        $objectManager = $serviceManager->get('doctrine.entitymanager.orm_default');
        $user = $objectManager->getRepository('Registry\Entity\User')->findOneBy(array('identity' => '999999999'));
        
        $this->assertEquals(1, $user->getStatus());

        $bcrypt = new Bcrypt();
        $authService = $serviceManager->get('zfcuser_user_service');
        $bcrypt->setCost($authService->getOptions()->getPasswordCost());
        $this->assertFalse($bcrypt->verify('dummypass', $user->getCredential()));
        $this->assertTrue($bcrypt->verify('passedited', $user->getCredential()));
    }

    public function testDeleteActionCantAccess()
    {
        $this->dispatch('/users/delete?id=20000');
        $this->assertResponseStatusCode(302);
    }

    /**
     * @depends testEditActionAccess
     */
    public function testDeleteActionCanAccess()
    {
        $serviceManager = $this->getApplicationServiceLocator();
        $objectManager = $serviceManager->get('doctrine.entitymanager.orm_default');
        self::$dummyUser = $objectManager->getRepository('Registry\Entity\User')->findOneBy(array('identity' => '999999999'));
        if (!is_object(self::$dummyUser)) {
            $this->markTestIncomplete('No se encontro el usuario DUMMY para correr los tests');
        }

        $this->dispatch('/users/delete?id=' . self::$dummyUser->getId());

        $this->assertResponseStatusCode(200);
    }

    public function testDeleteActionHimself()
    {
        $this->dispatch('/users/delete?id=1');
        $this->assertResponseStatusCode(302);
    }

    /**
     * @depends testEditActionAccess
     */
    public function testDeleteActionPRG()
    {
        $this->dispatch('/users/delete?id=' . self::$dummyUser->getId(), 'POST', array());
        $this->assertResponseStatusCode(303);
    }

    /**
     * @depends testEditActionAccess
     */
    public function testDeleteActionInvalidForm()
    {
        $post = new Container('prg_post1');
        $post->post = array(
            'csrf' => 'testhash',
            'element' => '20000'
        );

        $csrf = new Container('Zend_Validator_Csrf_salt_csrf');
        $csrf->hash = 'testhash';

        $this->dispatch('/users/delete?id=' . self::$dummyUser->getId());

        $this->assertResponseStatusCode(302);
    }

    /**
     * @depends testEditActionAccess
     */
    public function testDeleteActionValidForm()
    {
        $post = new Container('prg_post1');
        $post->post = array(
            'csrf' => 'testhash',
            'element' => self::$dummyUser->getId()
        );

        $csrf = new Container('Zend_Validator_Csrf_salt_csrf');
        $csrf->hash = 'testhash';

        $this->dispatch('/users/delete?id=' . self::$dummyUser->getId());

        $this->assertResponseStatusCode(302);

        $serviceManager = $this->getApplicationServiceLocator();
        $objectManager = $serviceManager->get('doctrine.entitymanager.orm_default');
        $user = $objectManager->getRepository('Registry\Entity\User')->findOneBy(array('identity' => '999999999'));

        $this->assertFalse(is_object($user));
    }
}
