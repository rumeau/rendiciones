<?php
namespace Registry\Model;

use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\ConfigInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\InitializableInterface;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;

class ModelManager extends AbstractPluginManager
{
    /**
     * Don't share form elements by default
     *
     * @var bool
     */
    protected $shareByDefault = false;

    /**
     * @param ConfigInterface $configuration
     */
    public function __construct(ConfigInterface $configuration = null)
    {
        parent::__construct($configuration);

        $this->addInitializer(array($this, 'injectEntityManager'));
    }

    /**
     * Inject the factory to any element that implements FormFactoryAwareInterface
     *
     * @param $element
     */
    public function injectEntityManager($model)
    {
        if ($model instanceof Model) {
            if ($this->serviceLocator instanceof ServiceLocatorInterface
            && $this->serviceLocator->has('doctrine.entitymanager.orm_default')
            ) {
                $entityManager = $this->serviceLocator->get('doctrine.entitymanager.orm_default');
                $model->setObjectManager($entityManager);
            }
        }
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
        
        return;
    }
}
