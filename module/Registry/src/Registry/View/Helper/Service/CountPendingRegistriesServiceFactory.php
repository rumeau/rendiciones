<?php
namespace Registry\View\Helper\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Registry\View\Helper\CountPendingRegistries;

class CountPendingRegistriesServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $serviceLocator = $serviceLocator->getServiceLocator();
        $helper = new CountPendingRegistries();
        $objectManager = $serviceLocator->get('doctrine.entitymanager.orm_default');
        $helper->setObjectManager($objectManager);

        return $helper;
    }
}
