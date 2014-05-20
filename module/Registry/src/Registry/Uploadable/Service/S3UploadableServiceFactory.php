<?php
namespace Registry\Uploadable\Service;

use Registry\Uploadable\S3UploadableListener;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class S3UploadableServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $listener = new S3UploadableListener();
        $config = $serviceLocator->get('Config')['s3storage'];
        $listener->addS3Support($serviceLocator->get('aws'), $config);

        return $listener;
    }
}
