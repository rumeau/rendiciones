<?php
namespace Registry\Model\Service;

use Zend\Mvc\Service\AbstractPluginManagerFactory;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\InitializableInterface;
use Registry\Model\Model;

class ModelManagerServiceFactory extends AbstractPluginManagerFactory
{
    const PLUGIN_MANAGER_CLASS = 'Registry\Model\ModelManager';

    /**
     * Create and return the MVC controller plugin manager
     *
     * @param  ServiceLocatorInterface $serviceLocator
     * @return ModelManager
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $plugins = parent::createService($serviceLocator);
        $plugins->addPeeringServiceManager($serviceLocator);
        $plugins->setRetrieveFromPeeringManagerFirst(true);

        return $plugins;
    }

    /**
     * Validate the plugin
     *
     * Checks that the element is an instance of ElementInterface
     *
     * @param  mixed $plugin
     * @throws Exception\InvalidElementException
     * @return void
     */
    public function validatePlugin($plugin)
    {
        // Hook to perform various initialization, when the element is not created through the factory
        if ($plugin instanceof InitializableInterface) {
            $plugin->init();
        }
        
        if ($plugin instanceof Model) {
            return; // we're okay
        }
        
        throw new Exception\InvalidElementException(sprintf(
            'Plugin of type %s is invalid; must implement Zend\Form\ElementInterface',
            (is_object($plugin) ? get_class($plugin) : gettype($plugin))
        ));
    }
}
