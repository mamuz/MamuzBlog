<?php

return array(
    'router'             => array(
        'routes' => array(
            'blogPublishedPosts' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'       => '/blog[/:tag][/p/:page]',
                    'constraints' => array(
                        'tag'  => '[a-zA-Z0-9_+%-]*',
                        'page' => '[1-9][0-9]*',
                    ),
                    'defaults'    => array(
                        'controller' => 'MamuzBlog\Controller\PostQuery',
                        'action'     => 'publishedPosts',
                        'page'       => 1,
                    ),
                ),
            ),
            'blogPublishedPost'  => array(
                'type'    => 'segment',
                'options' => array(
                    'route'       => '/blog/post[/:id][/:title]',
                    'constraints' => array(
                        'id' => '[a-zA-Z0-9]+',
                        'title' => '[a-zA-Z0-9_+%-]+',
                    ),
                    'defaults'    => array(
                        'controller' => 'MamuzBlog\Controller\PostQuery',
                        'action'     => 'publishedPost',
                    ),
                ),
            ),
            'blogTags'           => array(
                'type'    => 'segment',
                'options' => array(
                    'route'       => '/blog/tags[/p/:page]',
                    'constraints' => array(
                        'page' => '[1-9][0-9]*',
                    ),
                    'defaults'    => array(
                        'controller' => 'MamuzBlog\Controller\TagQuery',
                        'action'     => 'list',
                        'page'       => 1,
                    ),
                ),
            ),
        ),
    ),
    'controllers'        => array(
        'factories' => array(
            'MamuzBlog\Controller\PostQuery' => 'MamuzBlog\Controller\PostQueryControllerFactory',
            'MamuzBlog\Controller\TagQuery'  => 'MamuzBlog\Controller\TagQueryControllerFactory',
        ),
    ),
    'controller_plugins' => array(
        'invokables' => array(
            'viewModelFactory' => 'MamuzBlog\Controller\Plugin\ViewModelFactory',
            'routeParam'       => 'MamuzBlog\Controller\Plugin\RouteParam',
        ),
    ),
    'service_manager'    => array(
        'factories' => array(
            'MamuzBlog\DomainManager' => 'MamuzBlog\DomainManager\Factory',
        ),
    ),
    'blog_domain'        => array(
        'factories' => array(
            'MamuzBlog\Crypt\HashIdAdapter' => 'MamuzBlog\Crypt\HashIdAdapterFactory',
            'MamuzBlog\Service\PostQuery'   => 'MamuzBlog\Service\PostQueryFactory',
            'MamuzBlog\Service\TagQuery'    => 'MamuzBlog\Service\TagQueryFactory',
        ),
    ),
    'view_helpers'       => array(
        'invokables' => array(
            'panel'          => 'MamuzBlog\View\Helper\Panel',
            'tag'            => 'MamuzBlog\View\Helper\Tag',
            'tagAnchor'      => 'MamuzBlog\View\Helper\TagAnchor',
            'permaLink'      => 'MamuzBlog\View\Helper\PermaLink',
            'postMeta'       => 'MamuzBlog\View\Helper\PostMeta',
            'postPanel'      => 'MamuzBlog\View\Helper\PostPanel',
            'postPanelShort' => 'MamuzBlog\View\Helper\PostPanelShort',
        ),
        'factories'  => array(
            'anchor'         => 'MamuzBlog\View\Helper\AnchorFactory',
            'anchorBookmark' => 'MamuzBlog\View\Helper\AnchorBookmarkFactory',
            'hashId'         => 'MamuzBlog\View\Helper\HashIdFactory',
            'postPager'      => 'MamuzBlog\View\Helper\PostPagerFactory',
            'tagPager'       => 'MamuzBlog\View\Helper\TagPagerFactory',
            'tagList'        => 'MamuzBlog\View\Helper\TagListFactory',
            'slugify'        => 'MamuzBlog\View\Helper\SlugFactory',
        ),
    ),
    'view_manager'       => array(
        'template_map'        => include __DIR__ . '/../template_map.php',
        'template_path_stack' => array(__DIR__ . '/../view'),
        'strategies'          => array('ViewJsonStrategy'),
    ),
    'doctrine'           => array(
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
    'mamuz-blog'         => array(
        'pagination' => array(
            'range' => array(
                'post' => 2,
                'tag'  => 10,
            ),
        ),
    ),
);
