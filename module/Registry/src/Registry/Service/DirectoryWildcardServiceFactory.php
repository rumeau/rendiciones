<?php
namespace Registry\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Registry\AssetManager\Resolver\DirectoryWildcard;

class DirectoryWildcardServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('config');
        $resolver = new DirectoryWildcard();
        $paths = array();

        if (isset($config['asset_manager']['resolver_configs']['directory_wildcard'])) {
            $paths = $config['asset_manager']['resolver_configs']['directory_wildcard'];
        }

        $resolver->addWildcard($paths);

        return $resolver;
    }
}
