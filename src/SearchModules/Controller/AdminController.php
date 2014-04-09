<?php

/**
 * @package Search
 */
namespace SearchModules\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel,
    Zend\ServiceManager\ServiceLocatorAwareInterface,
    Zend\ServiceManager\ServiceLocatorInterface;

class AdminController extends AbstractActionController implements ServiceLocatorAwareInterface
{

    /**
     * @var ServiceLocatorInterface
     * */
    protected $serviceLocator;

    /**
     *
     * @var Search\Service\Search
     * 
     **/

    protected $searchService;

     /**
     *
     * @var FormElementManager
     * 
     **/

    protected $formManager;

    public function indexAction()
    {
        $results = $this->getSearchService()->getRepository()->findAll();
        
        return new ViewModel(array(
            'results'   =>  $results
        ));
    }

    public function buildIndexAction(){
        $this->getServiceLocator()->get('SearchModules\Service\Indexer')->build();
        $this->fm('Data re-indexed', 'success');
        return $this->redirect()->toRoute( '/admin' );
    }
    /**
    *
    * Getters & setters
    *
    */

    /**
     * Gets the value of serviceLocator.
     *
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    /**
     * Sets the value of serviceLocator.
     *
     * @param ServiceLocatorInterface $serviceLocator the service locator
     *
     * @return self
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;

        return $this;
    }


    /**
     * Gets the value of searchService.
     *
     * @return mixed
     */
    public function getSearchService()
    {
        if(!$this->searchService){
            $this->setSearchService( $this->getServiceLocator()->get('SearchModules\Service\Search') );
        }
        return $this->searchService;
    }

    /**
     * Sets the value of searchService.
     *
     * @param mixed $searchService the post service
     *
     * @return self
     */
    public function setSearchService($searchService)
    {
        $this->searchService = $searchService;

        return $this;
    }

    /**
     * Gets the value of formManager.
     *
     * @return mixed
     */
    public function getFormManager()
    {
        if(!$this->formManager){
            $this->setFormManager( $this->getServiceLocator()->get('FormElementManager') );
        }
        return $this->formManager;
    }

    /**
     * Sets the value of formManager.
     *
     * @param mixed $formManager the form manager
     *
     * @return self
     */
    public function setFormManager($formManager)
    {
        $this->formManager = $formManager;

        return $this;
    }
}
