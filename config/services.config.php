<?php
namespace Media;
use Media\Service\Media as MediaService;
use Imagine\Gd\Imagine;
return array(
	'factories'=>array(
        'Media\Service\Media' => function($sm) {
            $entityManager = $sm->get('Doctrine\ORM\EntityManager');

            return new MediaService(
                $entityManager,
                $entityManager->getRepository('Media\Entity\Image')
            );
        },
        'media_options'=>function($sm){
            $config = $sm->get('Config');
            return new Options\ModuleOptions(isset($config['lava_media']) ? $config['lava_media'] : array());
        },
        'Imagine\Gd\Imagine' => function($sm) {
            return new Imagine();
        },
	)
);