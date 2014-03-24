<?php

namespace SearchModules\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel,
    Zend\ServiceManager\ServiceLocatorAwareInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
    Zend\Paginator\Paginator;

use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter,
    Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;

use ZendSearch\Lucene\Lucene,
    ZendSearch\Lucene\Document,
    ZendSearch\Lucene\Document\Field,
    ZendSearch\Lucene\Index\Term,
    ZendSearch\Lucene\Search\QueryParser,
    ZendSearch\Lucene\Search\Query\Term as QueryTerm,
    ZendSearch\Lucene\Search\Query\Boolean;

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
        //http://framework.zend.com/manual/2.0/en/modules/zendsearch.lucene.searching.html#
        //http://stackoverflow.com/questions/7805996/zend-search-lucene-matches
        //http://framework.zend.com/manual/2.0/en/modules/zendsearch.lucene.index-creation.html
        $where = dirname(dirname(__FILE__)) . '/../../../../../data/search_index';
        $index = Lucene::open($where);
        // echo $index->count();
        // echo $index->numDocs();
        // 
        
        // $index = Lucene::create( $where  );

        // $doc = new Document();

        // // Store document URL to identify it in the search results
        // $doc->addField(Field::Text('url', '/news/some-other-post'));

        // // Index document contents
        // $doc->addField(Field::UnStored('contents', '<p>some content</p>'));

        // // Add document to the index
        // $index->addDocument($doc);
        // // exit;

        // $index = Lucene::open($where);
        $query = QueryParser::parse('moar');

        // $pathTerm  = new Term(
        //                      $where, 'path'
        //                  );
        // $pathQuery = new QueryTerm($pathTerm);

        // $query = new Boolean();
        // $query->addSubquery($userQuery, true /* required */);
        // $query->addSubquery($pathQuery, true /* required */);

        $hits = $index->find($query);
        // $hits = $index->find('content');
        var_dump($hits);exit;
        foreach ($hits as $hit) {
            // var_dump($hit->getDocument());exit;
            // return Zend\Search\Lucene\Document object for this hit
            $document = $hit->getDocument();

            // // return a Zend\Search\Lucene\Field object
            // // from the Zend\Search\Lucene\Document
            var_dump($document);continue;exit;

            // // return the string value of the Zend\Search\Lucene\Field object
            // echo $document->getFieldValue('url');

            // // same as getFieldValue()
            echo $document->url . '<br>';
        }

        exit;

        $page = $this->params('page');
	    $max = 20;
	    
	    $adapter = new DoctrineAdapter(new ORMPaginator($this->getSearchService()->getPaginator(($page - 1) * 20, $max)));
	     // $adapter = new DoctrineAdapter(new ORMPaginator($repository->createQueryBuilder('blog')));
        $paginator = new Paginator($adapter);

        // set the current page to what has been passed in query string, or to 1 if none set
        $paginator->setCurrentPageNumber((int)$this->params()->fromQuery('page', 1));
        // set the number of items per page to 10
        $paginator->setItemCountPerPage(10);
	    // $results = $this->repository->getPaginator(($page - 1) * 20, $max);

	    // $adapter = new Adapter($results);
	    // $paginator = new DoctrineAdapter( new Adapter($results) );
	    // $paginator->setCurrentPageNumber($page);
	    // $paginator->setItemCountPerPage($max);

	    return new ViewModel(array(
	        'results'  =>  $paginator
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