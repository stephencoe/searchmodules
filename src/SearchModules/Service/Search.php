<?php

namespace SearchModules\Service;

use Exception;

use Zend\ServiceManager\ServiceLocatorAwareInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
    ZfcBase\EventManager\EventProvider;

use ZendSearch\Lucene\Lucene,
    ZendSearch\Lucene\Search\QueryParser;

use SearchModules\Entity\SearchTerm as SearchTerm;

class Search extends EventProvider implements ServiceLocatorAwareInterface
{

    /**
     * @var Zend\ServiceManager\ServiceLocatorInterface
     */
    protected $serviceLocator;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository|\SearchModules\Entity\Term
     */
    protected $repository;

    /**
     *
     *  @var
     */
    protected $options;

    /**
     * @var SearchTerm $searchEntity
     * */
    protected $searchEntity = 'SearchModules\Entity\SearchTerm';

    public function create(SearchTerm $searchEntity)
    {
        $this->getEntityManager()->persist($searchEntity);
        $this->getEntityManager()->flush($searchEntity);
    }

    public function newSearchEntity(){
        return new $this->searchEntity;
    }
    
    /**
     * Search the index for a given term
     * @param  [type] $entity Pre built entity from the search form
     * @return Array         Results
     */
    public function searchIndex( $entity )
    {
        //http://framework.zend.com/manual/2.0/en/modules/zendsearch.lucene.searching.html#
        //http://stackoverflow.com/questions/7805996/zend-search-lucene-matches
        //http://framework.zend.com/manual/2.0/en/modules/zendsearch.lucene.index-creation.html
        try{
            $index = Lucene::open( $this->getOptions()->getIndexDir() );
        } catch(Exception $e){
            return array();
        }        

        $query = QueryParser::parse( $entity->getTerm() );

        $hits = $index->find($query);
        $entity->setCount( count( $hits ) );
        
        //save the search for reference
        $this->create($entity);

        return $hits;
    }

    /**
     * 
     * Getters and Setters
     * 
     * */

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
     * Gets the value of entityManager.
     *
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        return $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
    }

    /**
     * Sets the value of entityManager.
     *
     * @param \Doctrine\ORM\EntityManager $entityManager the entity manager
     *
     * @return self
     */
    public function setEntityManager(\Doctrine\ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;

        return $this;
    }

    /**
     * Gets the value of repository.
     *
     * @return \Doctrine\Common\Persistence\ObjectRepository|\SearchModules\Entity\Term
     */
    public function getRepository()
    {
        return $this->getEntityManager()->getRepository('SearchModules\Entity\Term');
    }

    /**
     * Sets the value of repository.
     *
     * @param \Doctrine\Common\Persistence\ObjectRepository|\SearchModules\Entity\Term $repository the repository
     *
     * @return self
     */
    public function setRepository($repository)
    {
        $this->repository = $repository;

        return $this;
    }

    /**
     * get service options
     *
     * @return 
     */
    public function getOptions()
    {;
        if (!$this->options){
            $this->setOptions($this->getServiceLocator()->get('search_options'));
        }
        return $this->options;
    }

    /**
     * set service options
     *
     * @param  $options
     */
    public function setOptions( $options)
    {
        $this->options = $options;
    }
}