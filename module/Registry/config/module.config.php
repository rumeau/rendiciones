<?php
namespace Registry;

return array(
    'controllers' => array(
        'invokables' => array(
            'Registry\Controller\Index'   => 'Registry\Controller\IndexController',
            'Registry\Controller\Review'  => 'Registry\Controller\ReviewController',
            'Registry\Controller\User'    => 'Registry\Controller\UserController',
            'Registry\Controller\Group'   => 'Registry\Controller\GroupController',
            'Registry\Controller\Comment' => 'Registry\Controller\CommentController',
        ),
    ),

    'controller_plugins' => array(
        'factories' => array(
            'user' => 'Registry\Mvc\Controller\Plugin\Service\UserServiceFactory',
        ),
        'invokables' => array(
            'sortParams' => 'Registry\Mvc\Controller\Plugin\SortParams',
            'registry' => 'Registry\Mvc\Controller\Plugin\Registry',
            'filepostredirectget' => 'Registry\Mvc\Controller\Plugin\CustomFilePostRedirectGet'
        ),
    ),
    'controller_plugin_config' => array(
        'user' => array(
            'allowed_moderators_ids' => array(
                'moderator',
                'administrator',
            ),
            'allowed_admins_ids' => array(
                'administrator',
            ),
        ),
    ),

    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/',
                    'defaults' => array(
                        'controller'    => 'Registry\Controller\Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    // This route is a sane default when developing a module;
                    // as you solidify the routes for your module, however,
                    // you may want to remove it and replace it with more
                    // specific routes.
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/home/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
            'registry' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/registry',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Registry\Controller',
                        'controller' => 'index',
                        'action' => 'index'
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:action]',
                            'defaults' => array(
                                'action' => 'index',
                            ),
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                        ),
                    ),
                    'comment' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/comment',
                            'defaults' => array(
                                'controller' => 'comment',
                                'action' => 'comment'
                            ),
                        ),
                    ),
                ),
            ),
            'review' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/review',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Registry\Controller',
                        'controller' => 'review',
                        'action' => 'index'
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:action]',
                            'defaults' => array(
                                'action' => 'index',
                            ),
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                        ),
                    ),
                    'comment' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/comment',
                            'defaults' => array(
                                'controller' => 'comment',
                                'action' => 'comment'
                            ),
                        ),
                    ),
                ),
            ),
            'users' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/users',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Registry\Controller',
                        'controller' => 'User',
                        'action' => 'index'
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:action]',
                            'default' => array(
                                'action' => 'index',
                            ),
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                        ),
                    ),
                ),
            ),
            'groups' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/groups',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Registry\Controller',
                        'controller' => 'Group',
                        'action' => 'index'
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:action]',
                            'default' => array(
                                'action' => 'index',
                            ),
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                        ),
                       ),
                   ),
            ),
        ),
    ),

    'service_manager' => array(
        'factories' => array(
            'zfcuser_user_mapper' => function ($sm) {
                return new Mapper\User(
                    $sm->get('zfcuser_doctrine_em'),
                    $sm->get('zfcuser_module_options')
                );
            },
            'Registry\Service\DirectoryWidcard' => 'Registry\Service\DirectoryWildcardServiceFactory',

            'ModelManager' => 'Registry\Model\Service\ModelManagerServiceFactory',
        ),
    ),

    'app_registry' => array(
        'upload_path' => __DIR__ . '/../../../data/uploads',
    ),

    'view_manager' => array(
        'template_map' => array(
            'registry/auth/lohin.phtml' => __DIR__ . '/../view/auth/login.phtml',
            'layout/mail' => __DIR__ . '/../view/layout/mail.phtml',
        ),
        'template_path_stack' => array(
            'Registry' => __DIR__ . '/../view',
            'zfcuser' => __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),

    'view_helpers' => array(
        'factories' => array(
            'sortlink' => 'Registry\View\Helper\Service\SortlinkServiceFactory',
            'user' => 'Registry\View\Helper\Service\UserServiceFactory',
            'countpendingregistries' => 'Registry\View\Helper\Service\CountPendingRegistriesServiceFactory'
        ),
        'invokables' => array(
            'registry' => 'Registry\View\Helper\Registry',
            'formMultiCheckbox' => 'Registry\Form\View\Helper\FormMultiCheckbox',
        ),
    ),
    'view_helper_config' => array(
        'user' => array(
            'allowed_moderators_ids' => array(
                'moderator',
                'administrator',
            ),
            'allowed_admins_ids' => array(
                'administrator',
            ),
        ),
    ),

    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    __DIR__ . '/../src/' . __NAMESPACE__ . '/Entity'
                )
            ),
            'loggable' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    __DIR__ . '/../../../vendor/gedmo/doctrine-extensions/lib/Gedmo/Loggable/Entity'
                )
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver',
                    'Gedmo\Loggable\Entity' => 'loggable'
                )
            )
        ),
        'eventmanager' => array(
            'orm_default' => array(
                'subscribers' => array(
                    'Gedmo\Timestampable\TimestampableListener',
                    'Gedmo\Loggable\LoggableListener',
                    'Gedmo\Uploadable',
                )
            )
        )
    ),

    'asset_manager' => array(
        'resolvers' => array(
            'Registry\Service\DirectoryWidcard' => 2000,
        ),

        'resolver_configs' => array(
            'collections' => array(
                'css/app.css' => array(
                    'bootstrap.css',
                    'metro.css',
                    'style.css' => 'assets/css/style.css',
                ),
                'js/app.js' => array(
                    'jquery.js',
                    'bootstrap.js',
                    'modernizr.js',
                ),

                // Create Registry
                'css/create-registry.css' => array(
                    'datepicker.css',
                    'fancy-file-input.css' => 'assets/bundle/fancyfile/fancy-file-input.css',
                    'theme-bootstrap.css' => 'assets/bundle/fancyfile/theme-bootstrap.css',
                ),
                'js/create-registry.js' => array(
                    'datepicker.js',
                    'fancyfile.js' => 'assets/bundle/fancyfile/fancy-file-input.js',
                ),

                // View Registry
                'js/view-registry.js' => array(
                    'assets/bundle/lightbox/js/lightbox.min.js',
                    'assets/js/accounting.min.js',
                ),
                'css/view-registry.css' => array(
                    'assets/bundle/lightbox/css/lightbox.css',
                ),

                // Users
                'js/users.js' => array(
                    'assets/bundle/switch/js/bootstrap-switch.min.js',
                    'assets/bundle/select/bootstrap-select.min.js'

                ),
                'css/users.css' => array(
                    'assets/bundle/switch/css/bootstrap3/bootstrap-switch.min.css',
                    'assets/bundle/select/bootstrap-select.min.css'
                ),

                // Groups
                'js/groups.js' => array(
                    'assets/bundle/select/bootstrap-select.min.js'
                ),
                'css/groups.css' => array(
                    'assets/bundle/select/bootstrap-select.min.css'
                ),
            ),
            'map' => array(
                'jquery.js' => __DIR__ . '/../assets/js/jquery-2.1.0.js',
                'bootstrap.js' => __DIR__ . '/../assets/js/bootstrap.js',
                'modernizr.js' => __DIR__ . '/../assets/js/modernizr.js',
                'datepicker.js' => __DIR__ . '/../assets/js/bootstrap-datepicker.js',
                'fancyfile.js' => __DIR__ . '/../assets/js/bootstrap-fancyfile.js',

                'js/uri.js' => __DIR__ . '/../assets/js/URI.min.js',

                'bootstrap.css' => __DIR__ . '/../assets/css/bootstrap.min.css',
                'metro.css' => __DIR__ . '/../assets/css/metro-bootstrap.css',
                'datepicker.css' => __DIR__ . '/../assets/css/datepicker.css',
                'fancyfile.css' => __DIR__ . '/../assets/css/bootstrap-fancyfile.min.css',

                'css/clear.svg' => __DIR__ . '/../assets/bundle/fancyfile/clear.svg',
                'css/upload.svg' => __DIR__ . '/../assets/bundle/fancyfile/upload.svg',

                'img/prev.png' => __DIR__ . '/../assets/bundle/lightbox/img/prev.png',
                'img/next.png' => __DIR__ . '/../assets/bundle/lightbox/img/next.png',
                'img/close.png' => __DIR__ . '/../assets/bundle/lightbox/img/close.png',
                'img/loading.gif' =>  __DIR__ . '/../assets/bundle/lightbox/img/loading.gif',

                'docs/font-awesome.css' => __DIR__ . '/../assets/docs/font-awesome.css',
            ),
            'paths' => array(
                __DIR__ . '/../'
            ),

            'directory_wildcard' => array(
                'userfiles' => __DIR__ . '/../../../data/uploads',
            ),
        ),
    ),

    'sxmail' => array(
        'configs' => array(
            'default' => array(
                'charset' => 'UTF-8',
                'transport' => array(
                    'type'      => 'smtp',
                    'options'   => array(
                        'name'              => 'localhost.localdomain',
                        'host'              => '127.0.0.1',
                        'connection_class'  => 'login',
                        'connection_config' => array(
                            'username' => 'user',
                            'password' => 'pass',
                        ),
                    ),
                ),
                'message' => array(
                    'layout'  => 'layout/mail',
                    'headers' => array(
                        'X-Powered-By'      => 'ZF2 and SxMail',
                    ),
                    'options' => array(
                        'from'  => array('no-reply@jprumeau.com', 'No-Reply')
                    ),
                ),
            ),
        ),
    ),
);
