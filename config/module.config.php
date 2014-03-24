<?php
namespace SearchableModules;

return array(
	//searchable modules are registered in this :)
	'lava_searchable'=>array(
		'modules'=>array(
			array(
				'name'=>'DynamicPages\Entity\Page',
				'fields'=>array(
					'title',
					'body',
				),
				'route'=>'cms-page'
			),
			array(
				'name'=>'Blog\Entity\Post',
				'fields'=>array(
					'title',
					'body',
				),
				'route'=>array(
					'name'=>'view',
					'params'=>array(
						'slug'
					),
					'format'=>'slug'
				)
			),
			array(
				'name'=>'Events\Entity\Event',
				'fields'=>array(
					'title',
					'body',
				),
				'route'=>array(
					'name'=>'view',
					'params'=>array(
						'slug',
						'id'
					),
					'format'=>'id-slug'
				)
			)
		),
	),
    'bjyauthorize' => array(
        'resource_providers' => array(
            'BjyAuthorize\Provider\Resource\Config' => array(
                'SearchableModules\Controller\Admin' => array(),
            ),
        ),
        'rule_providers'     => array(
            'BjyAuthorize\Provider\Rule\Config' => array(
                'allow' => array(
                    // VIEW ITEMS
                    array(array('editor'), 'SearchableModules\Controller\Admin', array('add', 'list')),
                )
            )
        ),
        'guards' => array(
            'BjyAuthorize\Guard\Controller' => array(
                array(
                    'controller' => 'SearchableModules\Controller\Admin',
                    'roles' => array('editor'),
                    'action'=>array('index', 'add', 'edit'),
                ),

                array(
                    'controller' => 'SearchableModules\Controller\Admin',
                    'roles' => array('publisher'),
                ),
            ),
            'BjyAuthorize\Guard\Route' => array(
                array('route' => 'zfcadmin/search/add', 'roles' => array('editor')),
                array('route' => 'zfcadmin/search/edit', 'roles' => array('editor')),
                array('route' => 'zfcadmin/search', 'roles' => array('editor')),

                array('route' => 'search', 'roles' => array('guest')),

            ),
        ),
    ),


    'navigation' => array(
        'admin' => array(
            // 'Staff'=>array(
            //     'icon'=>'entypo-doc-text',
            //     'label' => 'Staff',
            //     'resource' => 'SearchableModules\Controller\Admin',
            //     'privilege'=>'list',
            //     'order'=>3,
            //     'uri'=>'#',
            //     'pages'=>array(
            //         array(
            //             'label' => 'Team',
            //             'route' => 'zfcadmin/search',
            //         ),
            //         array(
            //             'label' => 'Categories',
            //             'route' => 'zfcadmin/search/categories',
            //         ),
            //     )
            // ),
        ),
    ),
    
    'router' => array(
        'routes' => array(
            'zfcadmin' => array(
                'child_routes' => array(
                    'search' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/search',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id'     => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'SearchableModules\Controller\Admin',
                                'action'     => 'index',
                            ),
                        ),
                    ),
                ),
            ),
            'search' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/search',
                    'defaults' => array(
                        'controller' => 'SearchableModules\Controller\Search',
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
            'SearchableModules\Controller\Search'=>'SearchableModules\Controller\SearchController',
            'SearchableModules\Controller\Admin' => 'SearchableModules\Controller\AdminController'
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
