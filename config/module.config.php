<?php
namespace SearchModules;

return array(
	//searchable modules are registered here
    //indexDir must be absolute, lucene throws an error if the path is "./data/search_index"
	'lava_searchable'=>array(
        'indexDir'=>'/hsphere/local/home/lavaunix/lowtherhall.vic.edu.au/data/search_index',
		'modules'=>array(
			array(
				'name'=>'DynamicPages\Entity\DynamicPage',
                'slug_field'=>'uri',
				'route'=>'cms-page'
			),
			array(
                'name'=>'Blog\Entity\Post',
                'slug_field'=>'slug',
                'route'=>'news/view'
            ),
            array(
                'name'=>'Events\Entity\Event',
                'slug_field'=>'slug',
                'route'=>'news/view'
            ),
		),
	),
    'bjyauthorize' => array(
        'resource_providers' => array(
            'BjyAuthorize\Provider\Resource\Config' => array(
                'SearchModules\Controller\Admin' => array(),
            ),
        ),
        'rule_providers'     => array(
            'BjyAuthorize\Provider\Rule\Config' => array(
                'allow' => array(
                    // VIEW ITEMS
                    array(array('editor'), 'SearchModules\Controller\Admin', array('add', 'list')),
                )
            )
        ),
        'guards' => array(
            'BjyAuthorize\Guard\Controller' => array(
                array(
                    'controller' => 'SearchModules\Controller\Search',
                    'action'=>array('index'),
                    'roles' => array('guest')
                ),

                array(
                    'controller' => 'SearchModules\Controller\Admin',
                    'roles' => array('editor'),
                    'action'=>array('index', 'add', 'edit', 'build-index'),
                ),

                array(
                    'controller' => 'SearchModules\Controller\Admin',
                    'roles' => array('publisher'),
                ),
            ),
            'BjyAuthorize\Guard\Route' => array(

                array('route' => 'zfcadmin/searchresults', 'roles' => array('editor')),
                array('route' => 'zfcadmin/searchresults/build-index', 'roles' => array('editor')),

                array('route' => 'search', 'roles' => array('guest')),

            ),
        ),
    ),


    'navigation' => array(
        'admin' => array(
            // 'Search'=>array(
            //     'icon'=>'entypo-search',
            //     'label' => 'Search Results',
            //     'resource' => 'SearchModules\Controller\Admin',
            //     'privilege'=>'list',
            //     'order'=>10,
            //     'route' => 'zfcadmin/searchresults',
            // ),
        ),
    ),
    
    'router' => array(
        'routes' => array(
            'zfcadmin' => array(
                'child_routes' => array(
                    'searchresults' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/search',
                            'defaults' => array(
                                'controller' => 'SearchModules\Controller\Admin',
                                'action'     => 'index',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'build-index' => array(
                                'type'    => 'Literal',
                                'options' => array(
                                    'route'    => '/build-index',
                                    'defaults' => array(
                                        'controller' => 'SearchModules\Controller\Admin',
                                        'action'     => 'buildIndex',
                                    ),
                                ),
                            )
                        )
                    ),
                   
                ),
            ),
            'search' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/search[?[t=:term]&[page=:page]]',
                    'defaults' => array(
                        'controller' => 'SearchModules\Controller\Search',
                        'action'     => 'index',
                    ),
                ),

            ),
        ),
    ),
    
    'view_manager' => array(
        'template_path_stack' => array(
            'search' => __DIR__ . '/../view',
        ),
    ),


    'controllers'=>array(
        'invokables'=>array(
            'SearchModules\Controller\Search'=>'SearchModules\Controller\SearchController',
            'SearchModules\Controller\Admin' => 'SearchModules\Controller\AdminController'
        )
    ),

	'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
            ),

            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                )
            ),
        ),
        'eventmanager' => array(
            'orm_default' => array(
                'subscribers' => array(
                    'Gedmo\Timestampable\TimestampableListener',
                 ),
            ),
        ),
    ),
);
