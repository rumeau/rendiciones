<?php
namespace RegistryTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Zend\Session\Container;
use Zend\Stdlib\Parameters;

class ReviewControllerTest extends AbstractHttpControllerTestCase
{
    protected $traceError = true;

    /**
     * ID de un registro de pruebas
     * 
     * @var integer
     */
    public static $dummyRegistryClosedId = 8;

    public static $dummyRegistryPendingId = 7;

    public static $dummyComment;

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

    public function testIndexActionAccess()
    {
    	$this->dispatch('/review');

    	$this->assertResponseStatusCode(200);
    	$this->assertModuleName('Registry');
    	$this->assertControllerName('Registry\Controller\Review');
    	$this->assertControllerClass('ReviewController');
    	$this->assertMatchedRouteName('review');
    }

    public function testIndexActionAccessNotAdmin()
    {
    	$this->mockAuth(false);
    	$this->dispatch('/review');

    	$this->assertResponseStatusCode(200);
    }

    public function testIndexActionWithParams()
    {
    	$this->dispatch('/review?filter=2&p=1&q=Test&sort=asc&by=status');

    	$this->assertResponseStatusCode(200);
    	$this->assertQuery('table.table tbody tr.success');
    }

    public function testIndexActionWithParamsNoResult()
    {
    	$this->dispatch('/review?filter=-1&p=1&q=Australopitecus');

    	$this->assertResponseStatusCode(200);
    	$this->assertQuery('table.table tbody tr p.text-muted');
    }

    public function testViewActionNotFound()
    {
    	$this->dispatch('/review/view?id=20000');

    	$this->assertResponseStatusCode(302);
    }

    public function testViewActionClosedRegistry()
    {
    	$this->dispatch('/review/view?id=' . self::$dummyRegistryClosedId);

    	$this->assertResponseStatusCode(200);
    	$this->assertQuery('div.page-header span.glyphicon-lock');
    }

    public function testViewActionPendingRegistry()
    {
    	$this->dispatch('/review/view?id=' . self::$dummyRegistryPendingId);

    	$this->assertResponseStatusCode(200);
    	$this->assertQuery('div.page-header span.label-warning');
    }

    public function testViewActionChangeItemStatusInvalidRequest()
    {
    	$this->getRequest()->getHeaders()->addHeaderLine('Accept', 'application/json');
    	$this->dispatch('/review/view?id=' . self::$dummyRegistryPendingId, 'GET', array(), true);

    	$contentType = $this->getResponse()->getHeaders()->get('Content-Type')->getMediaType();
    	$this->assertEquals($contentType, 'application/json');

    	$result = $this->getResponse()->getContent();
    	$result = json_decode($result);
    	$this->assertEquals($result->result, false);
    	$this->assertEquals($result->msg, 'Llamada invalida');
    }

    public function testViewActionChangeItemStatusRegistryNotFound()
    {
    	$this->getRequest()->getHeaders()->addHeaderLine('Accept', 'application/json');
    	$this->dispatch('/review/view?id=20000', 'POST', array(), true);

    	$contentType = $this->getResponse()->getHeaders()->get('Content-Type')->getMediaType();
    	$this->assertEquals($contentType, 'application/json');

    	$result = $this->getResponse()->getContent();
    	$result = json_decode($result);
    	$this->assertEquals($result->result, false);
    	$this->assertEquals($result->msg, 'La rendicion solicitada no pudo ser encontrada');
    }

    public function testViewActionChangeItemStatusItemNotFound()
    {
    	$this->getRequest()->getHeaders()->addHeaderLine('Accept', 'application/json');
    	$this->dispatch(
    		'/review/view?id=' . self::$dummyRegistryPendingId,
    		'POST',
    		array('item' => '20000','value' => '2'),
    		true
    	);

    	$contentType = $this->getResponse()->getHeaders()->get('Content-Type')->getMediaType();
    	$this->assertEquals($contentType, 'application/json');

    	$result = $this->getResponse()->getContent();
    	$result = json_decode($result);
    	$this->assertEquals($result->result, false);
    	$this->assertEquals($result->msg, 'El item solicitado no pudo ser encontrado');
    }

    public function testViewActionChangeItemStatusValid()
    {
    	$this->getRequest()->getHeaders()->addHeaderLine('Accept', 'application/json');
    	$this->dispatch(
    		'/review/view?id=' . self::$dummyRegistryPendingId,
    		'POST',
    		array('item' => '2', 'value' => '2'),
    		true
    	);

    	$contentType = $this->getResponse()->getHeaders()->get('Content-Type')->getMediaType();
    	$this->assertEquals($contentType, 'application/json');

    	$result = $this->getResponse()->getContent();
    	$result = json_decode($result);
    	$this->assertEquals($result->result, true);
    	$this->assertEquals($result->msg, 'El estado del item ha sido modificado');
    }

    public function testViewActionPRG()
    {
    	$this->dispatch('/review/view?id=' . self::$dummyRegistryPendingId, 'POST', array());

    	$this->assertResponseStatusCode(303);
    }

    protected function getDummyRegistry($reload = false)
    {
        $serviceManager = $this->getApplicationServiceLocator();
        $objectManager = $serviceManager->get('doctrine.entitymanager.orm_default');
        
        if ($reload !== false) {
            $id = is_int($reload) ? $reload : $reload->getId();
            return $objectManager->find('Registry\Entity\Registry', self::$dummyRegistryPendingId);
        }
        
        return $objectManager->find('Registry\Entity\Registry', self::$dummyRegistryPendingId);
    }

    public function testViewActionInvalidPost()
    {
    	$post = new Container('prg_post1');
        $post->post = array();
        
    	$this->dispatch('/review/view?id=' . self::$dummyRegistryPendingId);
    	$this->assertResponseStatusCode(302);
    }

    public function testViewActionValidPostAndClose()
    {
    	$registry = $this->getDummyRegistry();

    	$post = new Container('prg_post1');
        $post->post = array('csrf' => 'testhash', 'element' => self::$dummyRegistryPendingId, 'task' => 'review');
        
        $csrf = new \Zend\Session\Container('Zend_Validator_Csrf_salt_csrf');
        $csrf->hash = 'testhash';
        
        $this->dispatch('/review/view?id=' . self::$dummyRegistryPendingId);
    	$this->assertResponseStatusCode(302);

    	$registry = $this->getDummyRegistry($registry);
    	$this->assertEquals(\Registry\Entity\Registry::REGISTRY_STATUS_APPROVED, $registry->getStatus());
    }

    public function testViewActionValidPostAndReopen()
    {
    	$registry = $this->getDummyRegistry();

    	$post = new Container('prg_post1');
        $post->post = array('csrf' => 'testhash', 'element' => self::$dummyRegistryPendingId, 'task' => 'reopen');
        
        $csrf = new \Zend\Session\Container('Zend_Validator_Csrf_salt_csrf');
        $csrf->hash = 'testhash';
        
        $this->dispatch('/review/view?id=' . self::$dummyRegistryPendingId);
    	$this->assertResponseStatusCode(302);

    	$registry = $this->getDummyRegistry($registry);
    	$this->assertEquals(\Registry\Entity\Registry::REGISTRY_STATUS_PENDING, $registry->getStatus());
    }

    public function testViewActionValidPostAndCloseRejected()
    {
        $toReject = 5;
        $serviceManager = $this->getApplicationServiceLocator();
        $objectManager = $serviceManager->get('doctrine.entitymanager.orm_default');
        $item  = $objectManager->find('Registry\Entity\Item', $toReject);
        $item2 = $objectManager->find('Registry\Entity\Item', 2);
        if (!is_object($item)) {
            $this->markTestIncomplete('El item no pudo ser encontrado');
        } else {
            $item->setStatus(2);
            $objectManager->persist($item);
            $objectManager->flush();
        }

        $registry = $this->getDummyRegistry();

        $post = new Container('prg_post1');
        $post->post = array('csrf' => 'testhash', 'element' => self::$dummyRegistryPendingId, 'task' => 'review');
        
        $csrf = new \Zend\Session\Container('Zend_Validator_Csrf_salt_csrf');
        $csrf->hash = 'testhash';
        
        $this->dispatch('/review/view?id=' . self::$dummyRegistryPendingId);
        $this->assertResponseStatusCode(302);

        $registry = $this->getDummyRegistry($registry);
        $this->assertEquals(\Registry\Entity\Registry::REGISTRY_STATUS_REJECTED, $registry->getStatus());

        $registry->setStatus(\Registry\Entity\Registry::REGISTRY_STATUS_PENDING);
        $item->setStatus(1);

        $objectManager->persist($registry);
        $objectManager->persist($item);
        if (is_object($item2)) {
            $item2->setStatus(1);
            $objectManager->persist($item2);
        }
        $objectManager->flush();
    }

    public function testViewActionReopenOnCantReopen()
    {
        $registry = $this->getDummyRegistry();
        $registry->setStatus(4);

        $serviceManager = $this->getApplicationServiceLocator();
        $objectManager = $serviceManager->get('doctrine.entitymanager.orm_default');
        $objectManager->persist($registry);
        $objectManager->flush();

        $post = new Container('prg_post1');
        $post->post = array('csrf' => 'testhash', 'element' => self::$dummyRegistryPendingId, 'task' => 'reopen');
        
        $csrf = new \Zend\Session\Container('Zend_Validator_Csrf_salt_csrf');
        $csrf->hash = 'testhash';
        
        $this->dispatch('/review/view?id=' . self::$dummyRegistryPendingId);
        $this->assertResponseStatusCode(302);

        $registry = $this->getDummyRegistry($registry);
        $this->assertEquals(4, $registry->getStatus());
    }

    public function testViewActionCloseOnCantClose()
    {
        $post = new Container('prg_post1');
        $post->post = array('csrf' => 'testhash', 'element' => self::$dummyRegistryPendingId, 'task' => 'close');
        
        $csrf = new \Zend\Session\Container('Zend_Validator_Csrf_salt_csrf');
        $csrf->hash = 'testhash';
        
        $this->dispatch('/review/view?id=' . self::$dummyRegistryPendingId);
        $this->assertResponseStatusCode(302);

        $registry = $this->getDummyRegistry();
        $this->assertEquals(4, $registry->getStatus());

        $registry->setStatus(\Registry\Entity\Registry::REGISTRY_STATUS_PENDING);

        $serviceManager = $this->getApplicationServiceLocator();
        $objectManager = $serviceManager->get('doctrine.entitymanager.orm_default');
        $registry->setStatus(1);
        $objectManager->persist($registry);
        $objectManager->flush();
    }

    /**
     * Crea un mock de autenticacion con un usuario administrador
     */
    public function mockAuth($admin = true)
    {
    	$serviceManager = $this->getApplicationServiceLocator();
    	$objectManager = $serviceManager->get('doctrine.entitymanager.orm_default');

    	if ($admin) {
    		$user = $objectManager->find('Registry\Entity\User', 1);
    	} else {
    		$user = $objectManager->find('Registry\Entity\User', 2);
    	}
            
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
}
