<?php

namespace RegistryTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Zend\Session\Container;

class CommentControllerTest extends AbstractHttpControllerTestCase
{
    protected $traceError = true;
    
    public function setUp()
    {
        $config = 'config/application.config.php';
        // Zend Studio
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

    /*
    public function testCommentActionGet()
    {
        $this->dispatch('/registry/comment?id=' . self::$dummyRegistryPendingId);

        $this->assertResponseStatusCode(302);
    }

    public function testCommentActionGetInvalidRegistry()
    {
        $this->dispatch('/registry/comment?id=20000');

        $this->assertResponseStatusCode(302);
    }

    public function testCommentActionPRG()
    {
        $this->dispatch('/registry/comment?id=' . self::$dummyRegistryPendingId, 'POST', array());

        $this->assertResponseStatusCode(303);
    }

    public function testCommentActionInvalidForm()
    {
        $post = new Container('prg_post1');
        $post->post = array('comment' => array());

        $this->dispatch('/registry/comment?id=' . self::$dummyRegistryPendingId);
        $this->assertRedirectTo('/registry/view?id=' . self::$dummyRegistryPendingId);
    }

    public function testCommentActionValidForm()
    {
        $post = new Container('prg_post1');
        $post->post = array('comment' => array('comment' => 'TESTCOMMENT'));

        $this->dispatch('/registry/comment?id=' . self::$dummyRegistryPendingId);

        $serviceManager = $this->getApplicationServiceLocator();
        $objectManager = $serviceManager->get('doctrine.entitymanager.orm_default');
        $comment = $objectManager->getRepository('Registry\Entity\Comment')->findOneBy(array('comment' => 'TESTCOMMENT'));

        $this->assertInstanceOf('Registry\Entity\Comment', $comment);
        $this->assertEquals('TESTCOMMENT', $comment->getComment());
        $this->assertRedirectTo('/registry/view?id=' . self::$dummyRegistryPendingId . '#comment-' . $comment->getId());
    }

    public function testCommentAjaxActionAccessGet()
    {
        $this->getRequest()->getHeaders()->addHeaderLine('Accept', 'application/json');
        $this->dispatch('/registry/comment?id=' . self::$dummyRegistryPendingId, 'GET', array(), true);

        $contentType = $this->getResponse()->getHeaders()->get('Content-Type')->getMediaType();
        $this->assertEquals($contentType, 'application/json');

        $result = $this->getResponse()->getContent();
        $result = json_decode($result);
        $this->assertEquals($result->result, false);
        $this->assertEquals($result->msg, 'Llamada invalida');
    }

    public function testCommentAjaxActionAccessPostInvalid()
    {
        $this->getRequest()->getHeaders()->addHeaderLine('Accept', 'application/json');
        $this->dispatch('/registry/comment?id=' . self::$dummyRegistryPendingId, 'POST', array('comment' => '20000'), true);

        $contentType = $this->getResponse()->getHeaders()->get('Content-Type')->getMediaType();
        $this->assertEquals($contentType, 'application/json');

        $result = $this->getResponse()->getContent();
        $result = json_decode($result);
        $this->assertEquals($result->result, false);
        $this->assertEquals($result->msg, 'El comentario solicitado no pudo ser encontrado');
    }

    public function testCommentAjaxActionAccessPostValid()
    {
        $serviceManager = $this->getApplicationServiceLocator();
        $objectManager = $serviceManager->get('doctrine.entitymanager.orm_default');
        $comment = $objectManager->getRepository('Registry\Entity\Comment')->findOneBy(array('comment' => 'TESTCOMMENT'));
        if (!is_object($comment)) {
            $this->markTestIncomplete('No se encontrol el comentario de prueba');
        } else {
            $this->getRequest()->getHeaders()->addHeaderLine('Accept', 'application/json');
            $this->dispatch('/registry/comment?id=' . self::$dummyRegistryPendingId, 'POST', array('comment' => $comment->getId()), true);

            $contentType = $this->getResponse()->getHeaders()->get('Content-Type')->getMediaType();
            $this->assertEquals($contentType, 'application/json');

            $result = $this->getResponse()->getContent();
            $result = json_decode($result);
            $this->assertEquals($result->result, true);
            $this->assertEquals($result->msg, 'El comentario ha sido eliminado');
        }
    }*/
}
