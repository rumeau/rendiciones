<?php
namespace Registry\View\Helper\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Registry\View\Helper\Sortlink;

class SortlinkServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $sl = $serviceLocator->getServiceLocator();
        $request = $sl->get('Request');

        return new Sortlink($request);
    }
}
