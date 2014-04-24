<?php

namespace Registry\View\Helper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZfSnapPhpDebugBar\View\Helper\DebugBar;

/**
 * DebugBarFactory
 *
 * @author Witold Wasiczko <witold@wasiczko.pl>
 */
class DebugBarFactory implements FactoryInterface
{

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return DebugBar
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $sm = $serviceLocator->getServiceLocator();
        /* @var $debugbar \DebugBar\DebugBar */
        $debugbar = $sm->get('DebugBar');
        $renderer = $debugbar->getJavascriptRenderer();

        $renderer->setBaseUrl('/rendiciones/public/DebugBar/Resources/');
        $renderer->setBasePath('/rendiciones/public/DebugBar/Resources/');
        $renderer->renderOnShutdown(false);

        return new DebugBar($renderer);
    }

}
