<?php
namespace Registry\Mvc\Controller\Plugin\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Registry\Mvc\Controller\Plugin\User;

class UserServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $plugins)
    {
        $serviceLocator = $plugins->getServiceLocator();
        $plugin = new User();
        $objectManager = $serviceLocator->get('doctrine.entitymanager.orm_default');
        $plugin->setObjectManager($objectManager);
        $config = $serviceLocator->get('Config');
        if (isset($config['controller_plugin_config']['user'])) {
            $configPlugin = $config['controller_plugin_config']['user'];
            if (isset($configPlugin['allowed_moderators_ids'])) {
                $plugin->setAllowedModeratorIds($configPlugin['allowed_moderators_ids']);
            }
            if (isset($configPlugin['allowed_admins_ids'])) {
                $plugin->setAllowedAdminIds($configPlugin['allowed_admins_ids']);
            }
        }

        return $plugin;
    }
}
