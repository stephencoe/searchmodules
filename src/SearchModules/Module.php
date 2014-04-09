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
        
        foreach ($search->getOptions()->getModules() as $module) {
            // var_dump($module['name']);exit;
            $sharedManager->attach($module['name'],'create.post', function($e)  use ($search) {
                // var_dump($e);exit;
               // $search->indexData($e);
            }, 100);
            
            $sharedManager->attach($module['name'],'edit.post', function($e)  use ($search) {
                // var_dump($e);exit;
                // $search->indexData($e);
            }, 100);
        }

        //check the build index cron
        $this->registerCron($event);
    }

    public function registerCron(MvcEvent $e)
    {
        $e->getApplication()
            ->getServiceManager()
            ->get('SearchModules\Service\Indexer')
            ->registerCron();
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
