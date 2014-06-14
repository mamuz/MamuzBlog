<?php

return array(
    'router'          => array(
        'routes' => array(
            'blogActivePosts' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'       => '/blog[/:tag][/p/:page]',
                    'constraints' => array(
                        'tag'  => '[a-zA-Z0-9_-]*',
                        'page' => '[1-9][0-9]*',
                    ),
                    'defaults'    => array(
                        'controller' => 'MamuzBlog\Controller\Query',
                        'action'     => 'activePosts',
                        'page'       => 1,
                    ),
                ),
            ),
            'blogActivePost'  => array(
                'type'    => 'segment',
                'options' => array(
                    'route'       => '/blog/post[/:id][/:title]',
                    'constraints' => array(
                        'id'    => '[a-zA-Z0-9]{9,}',
                        'title' => '[a-zA-Z0-9_+%-]+',
                    ),
                    'defaults'    => array(
                        'controller' => 'MamuzBlog\Controller\Query',
                        'action'     => 'activePost',
                    ),
                ),
            ),
        ),
    ),
    'controllers'     => array(
        'factories' => array(
            'MamuzBlog\Controller\Query' => 'MamuzBlog\Controller\QueryControllerFactory'
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'MamuzBlog\DomainManager' => 'MamuzBlog\DomainManager\Factory',
        ),
    ),
    'blog_domain'     => array(
        'factories' => array(
            'MamuzBlog\Crypt\HashIdAdapter' => 'MamuzBlog\Crypt\HashIdAdapterFactory',
            'MamuzBlog\Service\Query'       => 'MamuzBlog\Service\QueryFactory',
        ),
    ),
    'view_helpers'    => array(
        'invokables' => array(
            'postPanel' => 'MamuzBlog\View\Helper\PostPanel',
        ),
        'factories'  => array(
            'hashId' => 'MamuzBlog\View\Helper\HashIdFactory',
            'pager'  => 'MamuzBlog\View\Helper\PagerFactory',
        ),
    ),
    'view_manager'    => array(
        'template_map'        => include __DIR__ . '/../template_map.php',
        'template_path_stack' => array(__DIR__ . '/../view'),
        'strategies'          => array('ViewJsonStrategy'),
    ),
    'doctrine'        => array(
        'driver' => array(
            'mamuz_blog_entities' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/MamuzBlog/Entity'),
            ),
            'orm_default'         => array(
                'drivers' => array(
                    'MamuzBlog\Entity' => 'mamuz_blog_entities'
                ),
            ),
        ),
    ),
);
