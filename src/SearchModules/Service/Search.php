<?php

namespace Media\Service;
use Exception;

use Zend\ServiceManager\ServiceLocatorAwareInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
    ZfcBase\EventManager\EventProvider;

use Media\Entity\Image as ImageEntity;

class Media extends EventProvider implements ServiceLocatorAwareInterface
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
     * @var \Doctrine\Common\Persistence\ObjectRepository|\Media\Entity\Image
     */
    protected $repository;

    /**
     * @var Imagine\Gd\Imagine
     * */
    protected $imagine;

    /**
     *
     *  @var
     */
    protected $options;

    public function uploadImage($mediaEntity, $upload = array()){
        $uploader = $this->getServiceLocator()->get('UploadCenter\Service\Uploader')
                            ->setOptions($this->getOptions());
        try{
            $uploader->upload($mediaEntity, $upload['upload']);
            
            //get width and height for rendering
            $image = $this->getImagine()->open( $uploader->getFilename() );
            
            $mediaEntity
                ->setWidth( $image->getSize()->getWidth() )
                ->setHeight( $image->getSize()->getHeight() );
                
            $this->create($mediaEntity);
            return $mediaEntity;

        } catch(Exception $e){

            switch($e->getMessage()){
                case 'file exists' : 
                    
                    return $this->getRepository()->findOneBy(array(
                        'hash'=>$uploader->getHash()
                    ));

                break;
            }

            throw new Exception('invalid upload');
        }
    }

    /**
     * @var ImageEntity $mediaEntity
     * */
    public function create(ImageEntity $mediaEntity)
    {
        $this->getEntityManager()->persist($mediaEntity);
        $this->getEntityManager()->flush($mediaEntity);
    }

    /**
    * @var ImageEntity $mediaEntity
    */
    public function edit(ImageEntity $mediaEntity)
    {
        $this->getEntityManager()->flush();
    }

    /**
    * @var ImageEntity $mediaEntity
    */
    public function delete(ImageEntity $mediaEntity){
        $this->getEntityManager()->remove($mediaEntity);
        $this->getEntityManager()->flush();
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
     * @return \Doctrine\Common\Persistence\ObjectRepository|\Media\Entity\Image
     */
    public function getRepository()
    {
        return $this->getEntityManager()->getRepository('Media\Entity\Image');
    }

    /**
     * Sets the value of repository.
     *
     * @param \Doctrine\Common\Persistence\ObjectRepository|\Media\Entity\Image $repository the repository
     *
     * @return self
     */
    public function setRepository($repository)
    {
        $this->repository = $repository;

        return $this;
    }

    /**
     * Gets the value of imagine.
     *
     * @return Imagine\Gd\Imagine
     */
    public function getImagine()
    {
        if(!$this->imagine){
            $this->setImagine( $this->getServiceLocator()->get('Imagine\Gd\Imagine') );
        }
        return $this->imagine;
    }

    public function setImagine($imagine){
        $this->imagine = $imagine;
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
            $this->setOptions($this->getServiceLocator()->get('media_options'));
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