<?php

namespace Home\Controller;

use Cat\Model\CatTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use User\Form\UserForm;
use User\Model\UserTable;
use User\Model\User;
use User\Model\UserAuthAdapter;
use Zend\Authentication\AuthenticationService;
use Zend\Crypt\Password\Bcrypt;
use RuntimeException;

class HomeController extends AbstractActionController
{
    private $table;
    private $usertable;
    private $auth;

    public function __construct(CatTable $table, UserTable $usertable, AuthenticationService $auth)
    {
        $this->table = $table;
        $this->usertable = $usertable;
        $this->auth = $auth;
    }

    public function indexAction()
    {
        return new ViewModel([
            'cats' => $this->table->fetchAllDetailed(),
        ]);
    }

    // Using Zend/Authentication will handle persistent identity for me
    // Created adapter implementation that uses database to store user
    // Using Bcrypt to secure database in 
    public function signinAction()
    {
        if ($this->auth->hasIdentity()){
            return $this->redirect()->toRoute('home');
        }
        $form = new UserForm();
        $form->get('submit')->setValue('Sign In');

        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }

        $user = new User();
        $form->setInputFilter($user->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $user->exchangeArray($form->getData());
        $userAuthAdapter = new UserAuthAdapter($this->usertable);
        $userAuthAdapter->setUsername($user->username);
        $userAuthAdapter->setPassword($user->password);
        $result = $this->auth->authenticate($userAuthAdapter);

        if ($result->isValid()){
            return $this->redirect()->toRoute('cat');
        }

        $form->get('password')->setMessages(['Username or Password is invalid']);
        return ['form' => $form];
    }

    public function signUpAction()
    {
        if ($this->auth->hasIdentity()){
            return $this->redirect()->toRoute('home');
        }
        $form = new UserForm();
        $form->get('submit')->setValue('Create User');

        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }

        $user = new User();
        $form->setInputFilter($user->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $user->exchangeArray($form->getData());
        // Nobody likes storing plaintext passwords. Bcrypt seems to be the recommended way of 'encrypting' passwords in ZendFramework
        $bcrypt = new Bcrypt();
        $user->hashedPassword = $bcrypt->create($user->password);
        
        $this->usertable->createUser($user);
        try {
        } 
        catch (RuntimeException $e)
        {
            $form->get('username')->setMessages(['Username is in use']);
            return ['form' => $form];
        }   
        
        $userAuthAdapter = new UserAuthAdapter($this->usertable);
        $userAuthAdapter->setUsername($user->username);
        $userAuthAdapter->setPassword($user->password);
        // Should be success since the user was just created with theese credentials
        $result = $this->auth->authenticate($userAuthAdapter);

        // Should redirect back to signin if authentication failed
        return $this->redirect()->toRoute('cat');    
    }

    public function signoutAction()
    {
        $this->auth = new AuthenticationService();
        $this->auth->clearIdentity();
        return $this->redirect()->toRoute('home');    
    }
}