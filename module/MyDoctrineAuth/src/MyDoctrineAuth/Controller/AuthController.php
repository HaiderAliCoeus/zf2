<?php

namespace MyDoctrineAuth\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationServiceInterface;
use MyDoctrineAuth\Form\MyAuthForm;
use MyDoctrineAuth\Form\UserForm;
use Zend\View\Helper\ViewModel;
use Zend\View\Model\JsonModel;
use MyDoctrineAuth\Entity\User;
use Doctrine\ORM\EntityManager;
use Zend\Session\Container;
use Zend\EventManager\EventManager;

use Zend\Crypt\BlockCipher;
use MyDoctrineAuth\Event\SimpleEvent;

class AuthController extends AbstractActionController
{
    protected $em;

    public function getEntityManager()
    {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        }
        return $this->em;
    }

    protected $authService;
   
    public function __construct(AuthenticationServiceInterface $authService)
    {
        $this->authService = $authService;
    }
    public function getAuthService()
    {
        return $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
    }


    public function indexAction()
    {

        /*$foo = new SimpleEvent();
        $foo->getEventManager()->attach('echoHello_pre', function($e){
            echo "Wow! ";
        });
        $foo->getEventManager()->attach('echoHello_post', function($e){
            echo ". This example is very good! \n";
        });
        $foo->getEventManager()->attach('echoHello_post', function($e){
            echo "<br/>by gianarb92@gmail.com";
        }, -10);
        $foo->echoHello();*/


        $events = new EventManager;
        $events->attach('do', function($e) {
            $event  = $e->getName();
            $params = $e->getParams();

            printf(
                'Handled event "%s" with parameter "%s"',
                $event,
                json_encode($params)
            );
        });

        $params = array('foo' => 'bar','baz' => 'bat');
        $events->trigger('do', null, $params);
        //event, target, parameter
//print : Handled event "do" with parameter "{"foo":"bar","baz":"bat"}"
    }
    public function checkLoginAction(){
        if(!$this->getServiceLocator()->get('Zend\Authentication\AuthenticationService')->hasIdentity()){
            return new JsonModel(array( 'logged_in' => false));
        }else{
            return new JsonModel(array( 'logged_in' => true));

        }
    }
    
    public function loginAction()
    {
        $em = $this->getEntityManager();
        //you can grab this data from the Form in real life app
        $request = $this->getRequest();
        if( !$this->getServiceLocator()->get('Zend\Authentication\AuthenticationService')->hasIdentity()){
            $post = $request->getPost();
            $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
            $adapter = $authService->getAdapter();
            $adapter->setIdentityValue($post['email']);
            $adapter->setCredentialValue($post['password']);
            $authResult = $authService->authenticate();
            $user = $this->getEntityManager()->getRepository('MyDoctrineAuth\Entity\User')->findOneBy(array(
                'email' => $request->getPost('email')
            ));

            $container = new Container('user');
            $container->item = md5($user->getId());

            $em->persist($user);
            $em->flush();

            if ($authResult->isValid()) {
                return new JsonModel(array(
                    'user' => $user
                ));
            } else {
                return new JsonModel(array(
                    'status' => false
                ));
            }
        }else{
            return new JsonModel(array(
                'user' => $this->getEntityManager()->getRepository('MyDoctrineAuth\Entity\User')->findOneBy(array(
                    'email' => $request->getPost('email'),

                ))
            ));
        }
        die;


    }
    public function logoutAction()
    {
        $this->getAuthService()->clearIdentity();
        $container = new Container('user');
        unset($container->item);
        return new JsonModel(array('status' => true));
    }

    public function addUserAction(){
        $form = new UserForm();
        $form->get('submit')->setValue('Login');
        return array('form' => $form);
    }


    public function saveUserAction()
    {
        $em = $this->getEntityManager();

        $request = $this->getRequest();
       // print_r($request->getPost());

        $user = new User();
        $user->setEmail($request->getPost('email'));

        $bcrypt   = new \Zend\Crypt\Password\Bcrypt();
        $bcrypt->setSalt('m3s3Cr3tS4lty34h');

        $user->setPassword($bcrypt->create($request->getPost('password')));
        $user->setIsActive(1);

        $user->setUsersalt($bcrypt->create($user->getEmail()));
        $em->persist($user);
        $em->flush();
        return new JsonModel(array(
            array('user' => $user)
        ));
    }
}
