<?php
namespace Registry\View\Helper\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Registry\View\Helper\User;

class UserServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $serviceLocator = $serviceLocator->getServiceLocator();
        $helper = new User();
        $objectManager = $serviceLocator->get('doctrine.entitymanager.orm_default');
        $helper->setObjectManager($objectManager);
        $config = $serviceLocator->get('Config');
        if (isset($config['view_helper_config']['user'])) {
            $configHelper = $config['view_helper_config']['user'];
            if (isset($configHelper['allowed_moderators_ids'])) {
                $helper->setAllowedModeratorIds($configHelper['allowed_moderators_ids']);
            }
            if (isset($configHelper['allowed_admins_ids'])) {
                $helper->setAllowedAdminIds($configHelper['allowed_admins_ids']);
            }
        }

        return $helper;
    }
}
