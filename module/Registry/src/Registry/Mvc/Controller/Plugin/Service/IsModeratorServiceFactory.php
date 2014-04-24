<?php
namespace Registry\Mvc\Controller\Plugin\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Registry\Mvc\Controller\Plugin\IsModerator;

class IsModeratorServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $plugins)
    {
        $serviceLocator = $plugins->getServiceLocator();
        $plugin = new IsModerator();
        $objectManager = $serviceLocator->get('doctrine.entitymanager.orm_default');
        $plugin->setObjectManager($objectManager);
        $config = $serviceLocator->get('Config');
        if (isset($config['controller_plugin_config']['is_moderator'])) {
            $configPlugin = $config['controller_plugin_config']['is_moderator'];
            if (isset($configPlugin['allowed_moderators_ids'])) {
                $plugin->setAllowedModeratorIds($configPlugin['allowed_moderators_ids']);
            }
        }

        return $plugin;
    }
}
