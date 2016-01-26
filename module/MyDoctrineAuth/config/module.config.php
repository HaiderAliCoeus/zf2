<?php

return array(
    
    'doctrine' => array(
        'driver' => array(
            'MyDoctrineAuth_Entities' => array(
                'class' =>'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/MyDoctrineAuth/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    'MyDoctrineAuth\Entity' => 'MyDoctrineAuth_Entities'
                ),
            ),
        ),
        
        'authentication' => array(
            'orm_default' => array(
                'object_manager' => 'Doctrine\ORM\EntityManager',
                'identity_class' => 'MyDoctrineAuth\Entity\User',
                'identity_property' => 'email',
                'credential_property' => 'password',
                'credential_callable' => function(\MyDoctrineAuth\Entity\User $user, $passwordGiven) {
                    // using Bcrypt 
                    $bcrypt   = new \Zend\Crypt\Password\Bcrypt();
                    $bcrypt->setSalt('m3s3Cr3tS4lty34h');

                    // $passwordGiven is unhashed password that inputted by user
                    // $user->getPassword() is hashed password that saved in db
                    return $bcrypt->verify($passwordGiven, $user->getPassword());
                },
            ),
        ),
    ),
    
    'doctrine_factories' => array(
        'authenticationadapter' => 'MyDoctrineAuth\Factory\Authentication\AdapterFactory',
    ),
    
    'service_manager' => array(
        'factories' => array(
            'Zend\Authentication\AuthenticationService' => function($serviceManager) {
                return $serviceManager->get('doctrine.authenticationservice.orm_default');
            }
        ),
        'invokables' => array(
            'MySampleListener' => 'MyDoctrineAuth\Event\MySampleListener',
            'SimpleEvent' => 'MyDoctrineAuth\Event\SimpleEvent',
        ),
    ),
    'controllers' => array(
        'factories' => array(
            'MyDoctrineAuth\Controller\Auth' => function($controller) {
                $authController = new \MyDoctrineAuth\Controller\AuthController($controller->getServiceLocator()->get('Zend\Authentication\AuthenticationService'));
                return $authController;
            },
        ),
    ),
    
    
    'router' => array(
        'routes' => array(
            'auth' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/auth',
                    'defaults' => array(
                        '__NAMESPACE__' => 'MyDoctrineAuth\Controller',
                        'controller'    => 'Auth',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'process' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:action]',
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
            'save-user' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/auth/save-user',
                    'defaults' => array(
                        '__NAMESPACE__' => 'MyDoctrineAuth\Controller',
                        'controller'    => 'Auth',
                        'action'        => 'saveUser',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'process' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:action]',
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
            'login' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/login',
                    'defaults' => array(
                        '__NAMESPACE__' => 'MyDoctrineAuth\Controller',
                        'controller'    => 'Auth',
                        'action'        => 'login',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'process' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:action]',
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

        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'auth' => __DIR__ . '/../view',
        ),
    ),
);