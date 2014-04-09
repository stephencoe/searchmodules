<?php
namespace SearchModules;

return array(
    'factories' => array(
        'search_options'=>function($sm){
        	$config = $sm->get('Config');
            return new Options\ModuleOptions(isset($config['lava_searchable']) ? $config['lava_searchable'] : array());
        }
    ),
	'invokables'=>array(
        'SearchModules\Service\Search'	=>	'SearchModules\Service\Search',
        'SearchModules\Service\Indexer'	=>	'SearchModules\Service\Indexer',
    )
);