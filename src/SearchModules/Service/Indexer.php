<?php
namespace SearchModules\Service;

use Doctrine\ORM\EntityManager;
use Heartsentwined\Cron\Service\Cron;

use Zend\ServiceManager\ServiceLocatorAwareInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
    ZfcBase\EventManager\EventProvider;


use ZendSearch\Lucene\Lucene,
    ZendSearch\Lucene\Document,
    ZendSearch\Lucene\Document\Field;

class Indexer extends EventProvider implements ServiceLocatorAwareInterface
{
    /**
     *
     *  @var AbstractOptions
     */
    protected $options;

    /**
     * Build a full index of all modules flagged for indexing.
     * should be called from CLI or CRON
     */
    public function build(){
        echo 'building index....';
        $index = Lucene::create( $this->getOptions()->getIndexDir() );

        if($this->getOptions()->getModules()){
            foreach($this->getOptions()->getModules() as $module){
                $indexes = $this->getEntityManager()->getRepository( $module['name'] )->findAll();
                foreach($indexes as $dbindex){
                    $doc = new Document();

                    // Store document URL to identify it in the search results
                    $doc->addField(Field::Text('route', $module['route'] ));
                    
                    // produces "->getSlug() | ->getUri()" as the getter to allow different field for pages module
                    $getter = 'get' . ucfirst($module['slug_field']);
                    $doc->addField(Field::Text('slug', $dbindex->{$getter}() ));

                    $doc->addField(Field::Text('title', $dbindex->getTitle() ));
                    $doc->addField(Field::Text('description', $dbindex->getBody() ));

                    // Indexed document contents
                    $doc->addField(Field::UnStored('contents', $dbindex->getBody()));
                    $index->addDocument($doc);

                }
            }
        }
    }

    /**
     * cron job registration method
     */
    public function registerCron()
    {
        Cron::register(
            'build',
            $this->getCronFrequency(),
            array($this, 'build')
        );

        return $this;
    }


    public function getCronFrequency(){
        return $this->getOptions()->getIndexFrequencyExpression();
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
     * get service options
     *
     * @return 
     */
    public function getOptions()
    {;
        if (!$this->options){//} instanceof ) {
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