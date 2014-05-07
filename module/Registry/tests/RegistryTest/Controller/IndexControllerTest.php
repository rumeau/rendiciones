<?php

namespace RegistryTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Zend\Session\Container;

class IndexControllerTest extends AbstractHttpControllerTestCase
{
    protected $traceError = true;
    
    public static $dummyRegistry;

    public static $dummyRegistryPendingId = 7;
    
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
    
    public function testIndexActionCanBeAccessed()
    {
    	$this->dispatch('/');
    	$this->assertResponseStatusCode(200);
    
    	$this->assertModuleName('Registry');
    	$this->assertControllerName('Registry\Controller\Index');
    	$this->assertControllerClass('IndexController');
    	$this->assertMatchedRouteName('home');
    }
    
    public function testIndexActionWithParameters()
    {
    	$this->dispatch('/?filter=1&p=1&sort=asc&by=status');
    	$this->assertResponseStatusCode(200);
        
    	$this->assertControllerName('Registry\Controller\Index');
    	$this->assertMatchedRouteName('home');
    }
    
    public function testCreateActionAccess()
    {
    	$this->dispatch('/registry/create');
    	$this->assertResponseStatusCode(200);
        
    	$this->assertControllerName('Registry\Controller\Index');
    	$this->assertActionName('create');
    }
    
    public function testCreateActionPRG()
    {
        $this->dispatch('/registry/create', 'post', array());
    	$this->assertResponseStatusCode(303);
    
    	$this->assertControllerName('Registry\Controller\Index');
    	$this->assertActionName('create');
    }
    
    public function testCreateActionPostInvalid()
    {
        $post = new Container('file_prg_post1');
        $post->post = array();
        
    	$this->dispatch('/registry/create');
    	$this->assertResponseStatusCode(200);
    
    	$this->assertControllerName('Registry\Controller\Index');
    	$this->assertActionName('create');
    }
    
    public function testCreateActionPostInvalidForm()
    {
        $post = new Container('file_prg_post1');
        $post->post = array('formcsrf' => 'testhash', 'registry' => array('items' => array(array('document' => 1))));
        
        $csrf = new \Zend\Session\Container('Zend_Validator_Csrf_salt_formcsrf');
        $csrf->hash = 'testhash';
        
        $this->dispatch('/registry/create');
    	$this->assertResponseStatusCode(200);
        
    	$this->assertControllerName('Registry\Controller\Index');
    	$this->assertActionName('create');
    }
    
    public function testCreateActionPostValidForm()
    {
        $post = new Container('file_prg_post1');
    	$post->post = array(
    	    'formcsrf' => 'testhash',
    	    'registry' => array(
    	        'items' => array(
    	            0 => array(
    	                'document' => '1', 
    	                'description' => '', 
    	                'itemNumber' => '999999999', 
    	                'itemIdentifier' => '999999999', 
    	                'itemName' => 'TEST', 
    	                'itemDate' => '2014-01-01', 
    	                'itemGross' => '999', 
    	                'itemVat' => '0', 
    	                'itemTotal' => '999',
    	                'thefiles' => array(
    	                    0 => array(
    	                        'name' => 'test.jpg',
    	                		'type' => 'image/jpeg',
    	                		'size' => 542,
    	                		'tmp_name' => realpath(__DIR__ . '/../../_files/source-test.jpg'),
    	                		'error' => 0
    	                   ),
    	                )
    	            )
    	        ),
    	        'description' => 'TEST'
    	    ),
    	    'task' => 'draft',
    	);
    	$post->errors  = array();
    	$post->isValid = true;
    	$post->files = array();
        
    	$csrf = new \Zend\Session\Container('Zend_Validator_Csrf_salt_formcsrf');
    	$csrf->hash = 'testhash';
    
    	$this->dispatch('/registry/create');
    	$this->assertResponseStatusCode(302);
    	
    	$registry = $this->getDummyRegistry();
    	$this->assertInstanceOf('Registry\Entity\Registry', $registry);
    	$serviceManager = $this->getApplicationServiceLocator();
        $objectManager = $serviceManager->get('doctrine.entitymanager.orm_default');
        $objectManager->remove($registry);
        $objectManager->flush();
    }
    
    public function testCreateActionPostValidFormAndConfirm()
    {
    	$post = new Container('file_prg_post1');
    	$post->post = array(
    	    'formcsrf' => 'testhash',
    		'registry' => array(
    			'items' => array(
    				0 => array(
    					'document' => '1',
    					'description' => '',
    					'itemNumber' => '999999999',
    					'itemIdentifier' => '999999999',
    					'itemName' => 'TEST',
    					'itemDate' => '2014-01-01',
    					'itemGross' => '999',
    					'itemVat' => '0',
    					'itemTotal' => '999',
    					'thefiles' => array(
    					    0 => array(
    					        'name' => 'test.jpg',
    					        'type' => 'image/jpeg',
    					        'size' => 542,
    					        'tmp_name' => realpath(__DIR__ . '/../../_files/source-test.jpg'),
    					        'error' => 0
    					    ),
    					)
                    )
                ),
    			'description' => 'TEST'
    		),
    		'task' => 'save',
    	);
    	$post->errors  = array();
    	$post->isValid = true;
    	$post->files = array();
    
    	$csrf = new \Zend\Session\Container('Zend_Validator_Csrf_salt_formcsrf');
    	$csrf->hash = 'testhash';
    
    	$this->dispatch('/registry/create');
    	$this->assertResponseStatusCode(302);
    }
    
    protected function getDummyRegistry($reload = false)
    {
        $serviceManager = $this->getApplicationServiceLocator();
        $objectManager = $serviceManager->get('doctrine.entitymanager.orm_default');
        
        if ($reload !== false) {
            $id = is_int($reload) ? $reload : $reload->getId();
            return $objectManager->find('Registry\Entity\Registry', $id);
        }
        
        return $objectManager->getRepository('Registry\Entity\Registry')->findOneBy(array('description' => 'TEST'));
    }
    
    public function testEditActionAccess()
    {
        $registry = $this->getDummyRegistry();
        if (!is_object($registry)) {
            $this->markTestSkipped('The TEST Registry wasnt found');
        } else {
            $this->dispatch('/registry/edit?id=' . $registry->getId());
            $this->assertResponseStatusCode(200);
            
            $this->assertControllerName('Registry\Controller\Index');
            $this->assertActionName('edit');
        }
    }
    
    public function testEditActionAccessInvalid()
    {
    	$registry = $this->getDummyRegistry();
    	if (!is_object($registry)) {
    		$this->markTestSkipped('The TEST Registry wasnt found');
    	} else {
    		$this->dispatch('/registry/edit?id=20000');
    		$this->assertResponseStatusCode(302);
    	}
    }
    
    public function testEditActionPRG()
    {
        $registry = $this->getDummyRegistry();
        if (!is_object($registry)) {
        	$this->markTestSkipped('The TEST Registry wasnt found');
        } else {
            $this->dispatch('/registry/edit?id=' . $registry->getId(), 'post', array());
            $this->assertResponseStatusCode(303);
        
            $this->assertControllerName('Registry\Controller\Index');
            $this->assertActionName('edit');
        }
    }
    
    public function testEditActionPostInvalid()
    {
        $registry = $this->getDummyRegistry();
        if (!is_object($registry)) {
        	$this->markTestSkipped('The TEST Registry wasnt found');
        } else {
            $post = new Container('file_prg_post1');
            $post->post = array();
            
            $this->dispatch('/registry/edit?id=' . $registry->getId());
            $this->assertResponseStatusCode(200);
            
            $this->assertControllerName('Registry\Controller\Index');
            $this->assertActionName('edit');
        }
    }
    
    public function testEditActionPostInvalidForm()
    {
        $registry = $this->getDummyRegistry();
        if (!is_object($registry)) {
        	$this->markTestSkipped('The TEST Registry wasnt found');
        } else {
            $post = new Container('file_prg_post1');
            $post->post = array('formcsrf' => 'testhash', 'registry' => array('items' => array(array('type' => 1))));
            
            $csrf = new \Zend\Session\Container('Zend_Validator_Csrf_salt_formcsrf');
            $csrf->hash = 'testhash';
            
            $this->dispatch('/registry/edit?id=' . $registry->getId());
            $this->assertResponseStatusCode(200);
            
            $this->assertControllerName('Registry\Controller\Index');
            $this->assertActionName('edit');
        }
    }
    
    public function testEditActionPostValidForm()
    {
        $registry = $this->getDummyRegistry();
        if (!is_object($registry)) {
        	$this->markTestSkipped('The TEST Registry wasnt found');
        } else {
            $post = new Container('file_prg_post1');
            
            $post->post = array(
                'formcsrf' => 'testhash',
                'registry' => array(
                    'description' => 'TEST EDITED',
                    'items' => array(
                        0 => array(
                            'document' => '1',
                            'description' => '',
                            'itemNumber' => '999999999',
                            'itemIdentifier' => '999999999',
                            'itemName' => 'TEST',
                            'itemDate' => '2014-01-01',
                            'itemGross' => '999',
                            'itemVat' => '0',
                            'itemTotal' => '999',
                        ),
                    ),
                ),
                'task' => 'draft',
            );
            $post->errors  = array();
            $post->isValid = true;
            $post->files = array();
            
            $csrf = new \Zend\Session\Container('Zend_Validator_Csrf_salt_formcsrf');
            $csrf->hash = 'testhash';
            
            $this->dispatch('/registry/edit?id=' . $registry->getId());
            $this->assertResponseStatusCode(302);
            
            $registry = $this->getDummyRegistry($registry);
            $this->assertEquals('TEST EDITED', $registry->getDescription());
            
            $registry->setDescription('TEST');
            $serviceManager = $this->getApplicationServiceLocator();
            $objectManager = $serviceManager->get('doctrine.entitymanager.orm_default');
            $objectManager->persist($registry);
            $objectManager->flush();
        }
    }
    
    public function testEditActionPostValidFormConfirm()
    {
    	$registry = $this->getDummyRegistry();
    	if (!is_object($registry)) {
    		$this->markTestSkipped('The TEST Registry wasnt found');
    	} else {
    		$post = new Container('file_prg_post1');
    		
    		$post->post = array(
    		    'formcsrf' => 'testhash',
    			'registry' => array(
    			    'description' => 'TEST',
    			    'items' => array(
    				    0 => array(
    				        'document' => '1',
    						'description' => '',
    						'itemNumber' => '999999999',
    						'itemIdentifier' => '999999999',
    						'itemName' => 'TEST',
    						'itemDate' => '2014-01-01',
    						'itemGross' => '999',
    						'itemVat' => '0',
    						'itemTotal' => '999',
    				    ),
    				),
    			),
    			'task' => 'save',
    		);
    		$post->errors  = array();
    		$post->isValid = true;
    		$post->files = array();
    
    		$csrf = new \Zend\Session\Container('Zend_Validator_Csrf_salt_formcsrf');
    		$csrf->hash = 'testhash';
    
    		$this->dispatch('/registry/edit?id=' . $registry->getId());
    		$this->assertResponseStatusCode(302);
    	}
    }
    
    public function testViewActionCanView()
    {
        $registry = $this->getDummyRegistry();
        if (!is_object($registry)) {
        	$this->markTestSkipped('The TEST Registry wasnt found');
        } else {
        	$this->dispatch('/registry/view?id=' . $registry->getId());
        	$this->assertResponseStatusCode(200);
        	
        	$this->assertControllerName('Registry\Controller\Index');
        	$this->assertActionName('view');
        }
    }
    
    public function testViewActionPRG()
    {
    	$registry = $this->getDummyRegistry();
    	if (!is_object($registry)) {
    		$this->markTestSkipped('The TEST Registry wasnt found');
    	} else {
    		$this->dispatch('/registry/view?id=' . $registry->getId(), 'post', array());
    		$this->assertResponseStatusCode(303);
    
    		$this->assertControllerName('Registry\Controller\Index');
    		$this->assertActionName('view');
    	}
    }
    
    public function testViewActionCannotView()
    {
        $registry = $this->getDummyRegistry();
        if (!is_object($registry)) {
        	$this->markTestSkipped('The TEST Registry wasnt found');
        } else {
        	$this->dispatch('/registry/view?id=20000');
        	$this->assertResponseStatusCode(302);
        }
    }
    
    public function testViewActionConfirmInvalid()
    {
        $registry = $this->getDummyRegistry();
        if (!is_object($registry)) {
        	$this->markTestSkipped('The TEST Registry wasnt found');
        } else {
            $post = new Container('prg_post1');
            $post->post = array('csrf' => 'testhash', 'element' => '20000');
            
            $csrf = new \Zend\Session\Container('Zend_Validator_Csrf_salt_csrf');
            $csrf->hash = 'testhash';
            
            $this->dispatch('/registry/view?id=' . $registry->getId());
            $this->assertResponseStatusCode(302);
        }
    }
    
    public function testViewActionConfirmValid()
    {
    	$registry = $this->getDummyRegistry();
    	if (!is_object($registry)) {
    		$this->markTestSkipped('The TEST Registry wasnt found');
    	} else {
    		$post = new Container('prg_post1');
    		$post->post = array('csrf' => 'testhash', 'element' => $registry->getId(), 'task' => 'save');
            
    		$csrf = new \Zend\Session\Container('Zend_Validator_Csrf_salt_csrf');
    		$csrf->hash = 'testhash';
    
    		$this->dispatch('/registry/view?id=' . $registry->getId());
    		$this->assertResponseStatusCode(302);
    		
    		$registry = $this->getDummyRegistry($registry);
    		$this->assertEquals(\Registry\Entity\Registry::REGISTRY_STATUS_PENDING, $registry->getStatus());
    		$this->assertGreaterThan(0, $registry->getNumber());
    	}
    }
    
    public function testDeleteActionPending()
    {
        $registry = $this->getDummyRegistry();
        if (!is_object($registry)) {
        	$this->markTestSkipped('The TEST Registry wasnt found');
        } else {
            $post = new Container('prg_post1');
    		$post->post = array('csrf' => 'testhash', 'element' => $registry->getId());
            
    		$csrf = new \Zend\Session\Container('Zend_Validator_Csrf_salt_csrf');
    		$csrf->hash = 'testhash';
    
    		$this->dispatch('/registry/delete?id=' . $registry->getId());
    		$this->assertResponseStatusCode(302);
    		
            $serviceManager = $this->getApplicationServiceLocator();
            $objectManager = $serviceManager->get('doctrine.entitymanager.orm_default');
            $registry->setStatus(\Registry\Entity\Registry::REGISTRY_STATUS_DRAFT);
            $registry->setNumber(0);
            $objectManager->persist($registry);
            $objectManager->flush();
        }
    }
    
    public function testDeleteActionAccess()
    {
    	$registry = $this->getDummyRegistry();
    	if (!is_object($registry)) {
    		$this->markTestSkipped('The TEST Registry wasnt found');
    	} else {
    		$this->dispatch('/registry/delete?id=' . $registry->getId());
    		$this->assertResponseStatusCode(200);
    	}
    }
    
    public function testDeleteActionPRG()
    {
        $registry = $this->getDummyRegistry();
        if (!is_object($registry)) {
        	$this->markTestSkipped('The TEST Registry wasnt found');
        } else {
            $this->dispatch('/registry/delete?id=' . $registry->getId(), 'post', array());
            $this->assertResponseStatusCode(303);
            
            $this->assertControllerName('Registry\Controller\Index');
            $this->assertActionName('delete');
        }
    }
    
    public function testDeleteActionPostInvalid()
    {
    	$registry = $this->getDummyRegistry();
    	if (!is_object($registry)) {
    		$this->markTestSkipped('The TEST Registry wasnt found');
    	} else {
    		$post = new Container('prg_post1');
    		$post->post = array();
    
    		$this->dispatch('/registry/delete?id=' . $registry->getId());
    		$this->assertResponseStatusCode(302);
    	}
    }
    
    public function testDeleteActionPostInvalidForm()
    {
    	$registry = $this->getDummyRegistry();
    	if (!is_object($registry)) {
    		$this->markTestSkipped('The TEST Registry wasnt found');
    	} else {
    		$post = new Container('prg_post1');
    		$post->post = array('csrf' => 'testhash', 'element' => '20000');
    
    		$csrf = new \Zend\Session\Container('Zend_Validator_Csrf_salt_csrf');
    		$csrf->hash = 'testhash';
            
    		$this->dispatch('/registry/delete?id=' . $registry->getId());
    		$this->assertResponseStatusCode(302);
    	}
    }
    
    public function testDeleteActionPostValidForm()
    {
    	$registry = $this->getDummyRegistry();
    	if (!is_object($registry)) {
    		$this->markTestSkipped('The TEST Registry wasnt found');
    	} else {
    		$post = new Container('prg_post1');
    
    		$post->post = array('csrf' => 'testhash', 'element' => $registry->getId());
    
    		$csrf = new \Zend\Session\Container('Zend_Validator_Csrf_salt_csrf');
    		$csrf->hash = 'testhash';
            
    		$prevId = $registry->getId();
    		
    		$this->dispatch('/registry/delete?id=' . $registry->getId());
    		$this->assertResponseStatusCode(302);
            
    		$registry = $this->getDummyRegistry($prevId);
    		$this->assertNotInstanceOf('Registry\Entity\Registry', $registry);
    	}
    }
    
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
        $post->post = array('comment' => '');
        
        $this->dispatch('/registry/comment?id=' . self::$dummyRegistryPendingId);
        $this->assertRedirectTo('/registry/view?id=' . self::$dummyRegistryPendingId);
    }

    public function testCommentActionValidForm()
    {
        $post = new Container('prg_post1');
        $post->post = array('comment' => 'TESTCOMMENT');
        
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
        $headers = $this->getRequest()->getHeaders()->addHeaderLine('Accept', 'application/json');
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
        $headers = $this->getRequest()->getHeaders()->addHeaderLine('Accept', 'application/json');
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
            $headers = $this->getRequest()->getHeaders()->addHeaderLine('Accept', 'application/json');
            $this->dispatch('/registry/comment?id=' . self::$dummyRegistryPendingId, 'POST', array('comment' => $comment->getId()), true);

            $contentType = $this->getResponse()->getHeaders()->get('Content-Type')->getMediaType();
            $this->assertEquals($contentType, 'application/json');

            $result = $this->getResponse()->getContent();
            $result = json_decode($result);
            $this->assertEquals($result->result, true);
            $this->assertEquals($result->msg, 'El comentario ha sido eliminado');
        }
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
}
