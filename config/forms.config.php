<?php

use AdminInterface\Form\StandardForm as SearchForm;
use SearchModules\Form\Fieldset\Search as SearchFieldset;

return array(
    'factories' => array(
        'SearchModules\Form\Search' => function ($sm) {
            $form = new SearchForm('Search');

            $form->add($sm->get('Search\Form\Fieldset\Search'));

            return $form;
        },
        'Search\Form\Fieldset\Search' => function ($sm) {
            $fieldset = new SearchFieldset($sm->getServiceLocator()->get('Doctrine\ORM\EntityManager'));
            $fieldset->setUseAsBaseFieldset(true);
            return $fieldset;
        },
    ),
);