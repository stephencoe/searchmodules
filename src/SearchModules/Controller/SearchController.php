<?php

namespace SearchModules\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel,
    Zend\ServiceManager\ServiceLocatorAwareInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
    Zend\Paginator\Paginator;

use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter,
    Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;


class SearchController extends AbstractActionController implements ServiceLocatorAwareInterface
{

    /**
     * @var ServiceLocatorInterface
     * */
    protected $serviceLocator;

    /**
     *
     * @var SearchModules\Service\Search
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
        //PRG?
        $form       =   $this->getFormManager()->get('SearchModules\Form\Search');
        $request    =   $this->getRequest();
        $term       =   (string) $this->params()->fromQuery('t');
        $results    =   array();
        $entity     =   $this->getSearchService()->newSearchEntity();

        $entity->setTerm($term);

        $form->bind( $entity );
        
        if ($request->isPost()) {

            $form->setData($request->getPost());

            if ($form->isValid()) {
                $results = $this->getSearchService()->searchIndex($term);
            } else {
                $this->fm('Invalid search','error');
            }
        }

        $results = $this->getSearchService()->searchIndex($entity);

        // $page = $this->params('page');
        // $max = 20;
        
        // $adapter = new DoctrineAdapter(new ORMPaginator($this->getSearchService()->getPaginator(($page - 1) * 20, $max)));
        //  // $adapter = new DoctrineAdapter(new ORMPaginator($repository->createQueryBuilder('blog')));
        // $paginator = new Paginator($adapter);

        // // set the current page to what has been passed in query string, or to 1 if none set
        // $paginator->setCurrentPageNumber((int)$this->params()->fromQuery('page', 1));
        // // set the number of items per page to 10
        // $paginator->setItemCountPerPage(10);
        // $results = $this->repository->getPaginator(($page - 1) * 20, $max);

        // $adapter = new Adapter($results);
        // $paginator = new DoctrineAdapter( new Adapter($results) );
        // $paginator->setCurrentPageNumber($page);
        // $paginator->setItemCountPerPage($max);
        
        return new ViewModel(array(
            'results'   =>  $results,
            'term'      =>  $term
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
            $this->setSearchService( $this->getServiceLocator()->get('SearchModules\Service\Search') );
        }
        return $this->searchService;
    }

    /**
     * Sets the value of searchService.
     *
     * @param mixed $searchService the search service
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