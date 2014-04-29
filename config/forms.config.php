<?php

use AdminInterface\Form\StandardForm as SearchForm;
use SearchModules\Form\Fieldset\Search as SearchFieldset;

return array(
    'factories' => array(
        'SearchForm' => function ($sm) {
            $form = new SearchForm('Search');

            $form->add($sm->get('SearchFieldset'));

            return $form;
        },
        'SearchFieldset' => function ($sm) {
            $fieldset = new SearchFieldset($sm->getServiceLocator()->get('Doctrine\ORM\EntityManager'));
            $fieldset->setUseAsBaseFieldset(true);
            return $fieldset;
        },
    ),
);