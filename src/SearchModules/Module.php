<?php
namespace SearchModules;

use Zend\Loader\AutoloaderFactory,
    Zend\Loader\StandardAutoloader,
    Zend\ModuleManager\Feature\AutoloaderProviderInterface,
    Zend\ModuleManager\Feature\ConfigProviderInterface,
    Zend\Mvc\MvcEvent;

/**
 * SearchModules Module definition.
 */
class Module implements AutoloaderProviderInterface, ConfigProviderInterface
{

    public function onBootstrap(MvcEvent $event)
    {
        $eventManager   = $event->getApplication()->getEventManager();
        $sharedManager  = $eventManager->getSharedManager();
        $serviceManager = $event->getApplication()->getServiceManager();
        $search = $serviceManager->get('SearchModules\Service\Search');
        $search->buildIndex();
    }


    /**
     * {@inheritDoc}
     */
    public function getFormElementConfig(){
        
        return include __DIR__ . '/../../config/forms.config.php';
    }

    /**
     * {@inheritDoc}
     */
    public function getServiceConfig()
    {
        return include __DIR__ . '/../../config/services.config.php';
    }
    
    /**
     * {@inheritDoc}
     */
    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    /**
     * {@inheritDoc}
     */
    public function getAutoloaderConfig()
    {
        return array(
            AutoloaderFactory::STANDARD_AUTOLOADER => array(
                StandardAutoloader::LOAD_NS => array(
                    __NAMESPACE__ => __DIR__,
                ),
            ),
        );
    }
}
