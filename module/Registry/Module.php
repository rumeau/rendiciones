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
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/', __NAMESPACE__),
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function onBootstrap(MvcEvent $event)
    {
        // You may not need to do this if you're doing it elsewhere in your
        // application
        $eventManager        = $event->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $serviceLocator = $event->getApplication()->getServiceManager();
        $config = $serviceLocator->get('Config');
        $appConfig = isset($config['app_registry']) ? $config['app_registry'] : array();
        if (isset($appConfig['upload_path'])) {
            $uploaddableListener = $serviceLocator->get('Gedmo\Uploadable');
            $uploaddableListener->setDefaultPath($appConfig['upload_path']);
            //$uploaddableListener->setDefaultPath(realpath($appConfig['upload_path']) . DIRECTORY_SEPARATOR . date('mY'));
        }

        $eventManager->attachAggregate(new \Registry\Event\UserListener);
        $eventManager->attachAggregate(new \Registry\Event\RegistryListener);
        $eventManager->attachAggregate(new \Registry\Event\CommentListener);

        $cloudfrontConfig = isset($config['cloudfront']) ? $config['cloudfront'] : array();
        if (isset($cloudfrontConfig['domain']) && $serviceLocator->get('ViewHelperManager')->has('cloudfrontlink')) {
            $cloudfrontHelper = $serviceLocator->get('ViewHelperManager')->get('cloudfrontlink');
            $cloudfrontHelper->setDefaultDomain($cloudfrontConfig['domain']);
        }
    }

    public function getControllerConfig()
    {
        return array(
            'initializers' => array(
                'ObjectManager' => function ($controller, $controllerManager) {
                    $serviceLocator = $controllerManager->getServiceLocator();
                    $controller->objectManager = $serviceLocator->get('doctrine.entitymanager.orm_default');

                    return $controller;
                }
            )
        );
    }

    public function getFormElementConfig()
    {
        return array(
            'initializers' => array(
                'ObjectManager' => function ($form, $formManager) {
                    if ($form instanceof ObjectManagerAwareInterface) {
                        $serviceLocator = $formManager->getServiceLocator();
                        $form->setObjectManager($serviceLocator->get('doctrine.entitymanager.orm_default'));

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
                'EntityManager' => function ($instance, $serviceLocator) {
                    if ($instance instanceof EntityManager\EntityManagerAwareInterface) {
                        $instance->setEntityManager($serviceLocator->get('Zend\Db\Adapter\Adapter'));
                    }

                    return $instance;
                },
                'ObjectManager' => function ($instance, $serviceLocator) {
                    if ($instance instanceof \DoctrineModule\Persistence\ObjectManagerAwareInterface) {
                        $instance->setObjectManager($serviceLocator->get('doctrine.entitymanager.orm_default'));
                    }

                    return $instance;
                }
            )
        );
    }
}
