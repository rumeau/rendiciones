<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Registry for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Registry;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;

class Module implements AutoloaderProviderInterface
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
		    // if we're in a namespace deeper than one level we need to fix the \ in the path
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/' , __NAMESPACE__),
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function onBootstrap(MvcEvent $e)
    {
        // You may not need to do this if you're doing it elsewhere in your
        // application
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        
        $sl = $e->getApplication()->getServiceManager();
        $config = $sl->get('Config');
        $appConfig = isset($config['app_registry']) ? $config['app_registry'] : array();
        if (isset($appConfig['upload_path'])) {
        	$uploaddableListener = $sl->get('Gedmo\Uploadable');
        	$uploaddableListener->setDefaultPath(realpath($appConfig['upload_path']));
        	//$uploaddableListener->setDefaultPath(realpath($appConfig['upload_path']) . DIRECTORY_SEPARATOR . date('mY'));
        }
        
        $eventManager->attachAggregate(new \Registry\Event\UserListener);
        $eventManager->attachAggregate(new \Registry\Event\RegistryListener);
    }
    
    public function getControllerConfig()
    {
        return array(
        	'initializers' => array(
                'ObjectManager' => function($controller, $cm) {
                    $sl = $cm->getServiceLocator();
                    $controller->objectManager = $sl->get('doctrine.entitymanager.orm_default');
                    return $controller;
                }
            )
        );
    }
    
    public function getFormElementConfig()
    {
        return array(
        	'initializers' => array(
                'ObjectManager' => function($form, $fm) {
                	if ($form instanceof ObjectManagerAwareInterface) {
                    	$sl = $fm->getServiceLocator();
                    	$form->setObjectManager($sl->get('doctrine.entitymanager.orm_default'));
                    	return $form;
                	}
                }
            )
        );
    }
    
    public function getViewHelperConfig()
    {
    	\Zend\View\Helper\PaginationControl::setDefaultViewPartial('layout/paginator.phtml');
    	
    	return array();
    }

    public function getServiceConfig()
    {
        return array(
            'initializers' => array(
                'EntityManager' => function ($instance, $sm) {
                    if ($instance instanceof EntityManager\EntityManagerAwareInterface) {
                        $instance->setEntityManager($sm->get('Zend\Db\Adapter\Adapter'));
                    }
                    return $instance;
                },
                'ObjectManager' => function ($instance, $sm) {
                    if ($instance instanceof \DoctrineModule\Persistence\ObjectManagerAwareInterface) {
                        $instance->setObjectManager($sm->get('doctrine.entitymanager.orm_default'));
                    }
                    return $instance;
                }
            )
        );
    }
}
