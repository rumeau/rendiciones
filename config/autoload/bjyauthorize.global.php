<?php
return array(
    'bjyauthorize' => array(
        // Using the authentication identity provider, which basically reads the roles from the auth service's identity
        'identity_provider' => 'BjyAuthorize\Provider\Identity\AuthenticationIdentityProvider',
        
        'role_providers' => array(
            // using an object repository (entity repository) to load all roles into our ACL
            'BjyAuthorize\Provider\Role\ObjectRepositoryProvider' => array(
                'object_manager'    => 'doctrine.entitymanager.orm_default',
                'role_entity_class' => 'Registry\Entity\UserRole',
            ),
        ),
        
        'guards' => array(
            'BjyAuthorize\Guard\Route' => array(
                array('route' => 'zfcuser', 'roles' => array('user')),
                array('route' => 'zfcuser/logout', 'roles' => array('user')),
                array('route' => 'zfcuser/login', 'roles' => array('guest')),
                array('route' => 'zfcuser/register', 'roles' => array('guest')),
                // Below is the default index action used by the ZendSkeletonApplication
                array('route' => 'home', 'roles' => array('user')),
            	
            	array('route' => 'registry', 'roles' => array('user')),
            	array('route' => 'registry/default', 'roles' => array('user')),
            	array('route' => 'review', 'roles' => array('moderator', 'administrator')),
            	array('route' => 'review/default', 'roles' => array('moderator', 'administrator')),
            	
            	array('route' => 'users', 'roles' => array('administrator')),
            	array('route' => 'users/default', 'roles' => array('administrator')),
                
                array('route' => 'groups', 'roles' => array('administrator')),
                array('route' => 'groups/default', 'roles' => array('administrator')),
            ),
            'BjyAuthorize\Guard\Controller' => array(
                array('controller' => 'zfcuser', 'action' => array('index', 'login', 'logout', 'register'), 'roles' => array('user', 'guest')),
                array('controller' => 'Registry\Controller\Index',  'action' => array('index', 'view', 'comment', 'create', 'edit', 'delete'), 'roles' => array('user')),
            	array('controller' => 'Registry\Controller\Review', 'action' => array('index', 'view', 'comment'), 'roles' => array('moderator', 'administrator')),
            	array('controller' => 'Registry\Controller\User',   'action' => array('index', 'create', 'edit', 'delete'), 'roles' => array('administrator')),
                array('controller' => 'Registry\Controller\Group',   'action' => array('index', 'create', 'edit', 'delete'), 'roles' => array('administrator')),
            ),
        ),
        
        'unauthorized_strategy' => 'BjyAuthorize\View\RedirectionStrategy',
    ),
);
