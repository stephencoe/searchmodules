<?php
namespace SearchModules\Form\Fieldset;

use Zend\Form\Fieldset,
    Zend\InputFilter\InputFilterProviderInterface,
    Doctrine\Common\Persistence\ObjectManager,
    DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

class Search extends Fieldset implements InputFilterProviderInterface
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('Search');
        $this->setHydrator(new DoctrineHydrator($objectManager))
            ->setObject(new ImageEntity());
        
        
        
    }

    /**
     * @return array
     */
    public function getInputFilterSpecification() {
        return  array(
            
        );
    }
}