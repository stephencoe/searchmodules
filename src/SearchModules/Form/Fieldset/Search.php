<?php
namespace SearchModules\Form\Fieldset;

use Zend\Form\Fieldset,
    Zend\InputFilter\InputFilterProviderInterface;

use Doctrine\Common\Persistence\ObjectManager,
    DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

use SearchModules\Entity\SearchTerm as SearchTerm;

class Search extends Fieldset implements InputFilterProviderInterface
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('Search');
        $this->setHydrator(new DoctrineHydrator($objectManager))
            ->setObject(new SearchTerm());
        
        $this->add(array(
            'name' => 'term',
            'type'  => 'Zend\Form\Element\Text'
        ));
        
    }

    /**
     * @return array
     */
    public function getInputFilterSpecification() {
        return  array(
             'term' => array(
                'required' => false,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            ),
        );
    }
}