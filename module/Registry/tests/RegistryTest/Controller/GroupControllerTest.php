<?php

namespace RegistryTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Zend\Session\Container;

class GroupControllerTest extends AbstractHttpControllerTestCase
{
    protected $traceError = true;

    /**
     * @var int
     */
    public static $dummyGroupId;
    
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

    public function testCreateActionValidForm()
    {
        $post = new Container('prg_post1');
        $post->post = array(
            'formcsrf' => 'testhash',
            'group' => array(
                'name' => 'TESTGROUP',
                'description' => 'TESTDESCRIPTION',
                'users' => array('1')
            )
        );

        $csrf = new \Zend\Session\Container('Zend_Validator_Csrf_salt_formcsrf');
        $csrf->hash = 'testhash';

        $serviceManager = $this->getApplicationServiceLocator();
        $objectManager = $serviceManager->get('doctrine.entitymanager.orm_default');
        $curUser = $objectManager->find('Registry\Entity\User', 1);
        if ($curUser->getUserGroup()->getId() !== 1) {
            $this->markTestIncomplete('El usuario debe ser reseteado en el grupo para probarlo');
        }

        $this->dispatch('/groups/create');

        $this->assertResponseStatusCode(302);

        $dummyGroup = $objectManager->getRepository('Registry\Entity\UserGroup')->findOneBy(array('name' => 'TESTGROUP'));
        self::$dummyGroupId = $dummyGroup->getId();
        $this->assertInstanceOf('Registry\Entity\UserGroup', $dummyGroup);
        $users = $dummyGroup->getUsers();

        $this->assertInstanceOf('Doctrine\Common\Collections\Collection', $users);
        $this->assertTrue($users->count() === 1);
        $this->assertTrue($curUser->getUserGroup()->getId() === self::$dummyGroupId);
    }

    public function testEditActionCanAccess()
    {
        $serviceManager = $this->getApplicationServiceLocator();
        $objectManager = $serviceManager->get('doctrine.entitymanager.orm_default');
        $dummyGroup = $objectManager->find('Registry\Entity\UserGroup', self::$dummyGroupId);
        if (!is_object($dummyGroup)) {
            $this->markTestIncomplete('No se enctontro el grupo de prueba');
        }

        $this->dispatch('/groups/edit?id=' . self::$dummyGroupId);

        $this->assertResponseStatusCode(200);
    }

    public function testEditActionPRG()
    {
        $this->dispatch('/groups/edit?id=' . self::$dummyGroupId, 'POST');

        $this->assertResponseStatusCode(303);
    }

    public function testEditActionInvalidGroup()
    {
        $this->dispatch('/groups/edit?id=1');

        $this->assertResponseStatusCode(302);
    }

    public function testEditActionInvalidForm()
    {
        $post = new Container('prg_post1');
        $post->post = array();

        $csrf = new \Zend\Session\Container('Zend_Validator_Csrf_salt_formcsrf');
        $csrf->hash = 'testhash';

        $this->dispatch('/groups/edit?id=' . self::$dummyGroupId);

        $this->assertResponseStatusCode(200);
        $this->assertQuery('.has-error');
    }

    public function testEditActionValidForm()
    {
        $post = new Container('prg_post1');
        $post->post = array(
            'formcsrf' => 'testhash',
            'group' => array(
                'name' => 'TESTGROUPEDITED',
                'description' => 'TESTDESCRIPTION',
                'users' => array('1', '2')
            )
        );

        $csrf = new \Zend\Session\Container('Zend_Validator_Csrf_salt_formcsrf');
        $csrf->hash = 'testhash';

        $serviceManager = $this->getApplicationServiceLocator();
        $objectManager = $serviceManager->get('doctrine.entitymanager.orm_default');
        $curUser = $objectManager->find('Registry\Entity\User', 1);
        $newUser = $objectManager->find('Registry\Entity\User', 2);

        $this->assertTrue($newUser->getUserGroup()->getId() !== self::$dummyGroupId);

        $this->dispatch('/groups/edit?id=' . self::$dummyGroupId);

        $dummyGroup = $objectManager->find('Registry\Entity\UserGroup', self::$dummyGroupId);

        $this->assertResponseStatusCode(302);
        $this->assertEquals('TESTGROUPEDITED', $dummyGroup->getName());

        $users = $dummyGroup->getUsers();

        $this->assertInstanceOf('Doctrine\Common\Collections\Collection', $users);
        $this->assertTrue($users->count() === 2);
        $this->assertTrue($curUser->getUserGroup()->getId() === self::$dummyGroupId);
        $this->assertTrue($newUser->getUserGroup()->getId() === self::$dummyGroupId);
    }

    public function testDeleteActionGroupNotFound()
    {
        $this->dispatch('/groups/delete?id=20000');

        $this->assertResponseStatusCode(302);
    }

    public function testDeleteActionGroupNotEmpty()
    {
        $this->dispatch('/groups/delete?id=' . self::$dummyGroupId);

        $this->assertResponseStatusCode(302);
    }

    public function testEditActionRemoveUsers()
    {
        $post = new Container('prg_post1');
        $post->post = array(
            'formcsrf' => 'testhash',
            'group' => array(
                'name' => 'TESTGROUPEDITEDEMPTY',
                'description' => 'TESTDESCRIPTION',
                'users' => array()
            )
        );

        $csrf = new \Zend\Session\Container('Zend_Validator_Csrf_salt_formcsrf');
        $csrf->hash = 'testhash';

        $this->dispatch('/groups/edit?id=' . self::$dummyGroupId);

        $serviceManager = $this->getApplicationServiceLocator();
        $objectManager = $serviceManager->get('doctrine.entitymanager.orm_default');
        $curUser = $objectManager->find('Registry\Entity\User', 1);
        $newUser = $objectManager->find('Registry\Entity\User', 2);
        $this->assertEquals($curUser->getUserGroup()->getId(), 1);
        $this->assertEquals($newUser->getUserGroup()->getId(), 1);

        $newUser->setUserGroup($objectManager->getReference('Registry\Entity\UserGroup', 6));
        $objectManager->persist($newUser);
        $objectManager->flush();
    }

    public function testDeleteActionCanAccess()
    {
        $serviceManager = $this->getApplicationServiceLocator();
        $objectManager = $serviceManager->get('doctrine.entitymanager.orm_default');

        $this->dispatch('/groups/delete?id=' . self::$dummyGroupId);
        $this->assertResponseStatusCode(200);
        $this->assertQueryContentContains('div.page-header h2', 'Eliminar grupo');
    }

    public function testDeleteActionPRG()
    {
        $this->dispatch('/groups/delete?id=' . self::$dummyGroupId, 'POST', array());

        $this->assertResponseStatusCode(303);
    }

    public function testDeleteActionInvalidForm()
    {
        $post = new Container('prg_post1');
        $post->post = array();

        $csrf = new \Zend\Session\Container('Zend_Validator_Csrf_salt_csrf');
        $csrf->hash = 'testhash';

        $this->dispatch('/groups/delete?id=' . self::$dummyGroupId);

        $this->assertResponseStatusCode(302);
    }

    public function testDeleteActionValidForm()
    {
        $post = new Container('prg_post1');
        $post->post = array(
            'csrf' => 'testhash',
            'element' => self::$dummyGroupId
        );

        $csrf = new \Zend\Session\Container('Zend_Validator_Csrf_salt_csrf');
        $csrf->hash = 'testhash';

        $this->dispatch('/groups/delete?id=' . self::$dummyGroupId);

        $this->assertResponseStatusCode(302);

        $serviceManager = $this->getApplicationServiceLocator();
        $objectManager = $serviceManager->get('doctrine.entitymanager.orm_default');
        $dummyGroup = $objectManager->find('Registry\Entity\UserGroup', self::$dummyGroupId);
        $this->assertFalse(is_object($dummyGroup));
    }
}
