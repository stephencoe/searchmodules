<?php

use AdminInterface\Form\StandardForm as SearchForm;
use Search\Form\Fieldset\Search as SearchFieldset;

return array(
    'factories' => array(
        'Search\Form\Search' => function ($sm) {
            $form = new SearchForm('Search');

            $mediaFieldset = $sm->get('Media\Form\Fieldset\Media');
            $mediaFieldset->setUseAsBaseFieldset(true);
            $form->add($mediaFieldset);

            return $form;
        },
        'Search\Form\Fieldset\Search' => function ($sm) {
            $fieldset = new SearchFieldset($sm->getServiceLocator()->get('Doctrine\ORM\EntityManager'));
            $fieldset->setUseAsBaseFieldset(true);
            return $fieldset;
        },
    ),
);