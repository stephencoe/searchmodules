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
    const ADMIN_ROUTE = 'zfcadmin/searchresults';

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
     * @var Doctrine\ORM\EntityManager
     * 
     **/

    protected $entityManager;

    /**
     *
     * @var Search\Entity\SearchTerm
     * 
     **/

    protected $repository;

     /**
     *
     * @var FormElementManager
     * 
     **/

    protected $formManager;

    public function indexAction()
    {
        return new ViewModel(array(
            'results' => $this->getRepository()->findAll()
        ));
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
            $this->setSearchService( $this->getServiceLocator()->get('Search\Service\Search') );
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
