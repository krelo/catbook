<?php

namespace Home\Controller;

use Cat\Model\CatTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use User\Form\UserForm;
use User\Model\UserTable;
use User\Model\User;
use RuntimeException;

class HomeController extends AbstractActionController
{

    private $table;
    private $usertable;

    public function __construct(CatTable $table, UserTable $usertable)
    {
        $this->table = $table;
        $this->usertable = $usertable;
    }

    public function indexAction()
    {
        return new ViewModel([
            'cats' => $this->table->fetchAll(),
        ]);
    }

    public function signinAction()
    {
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
        
        try {

            $savedUser = $this->usertable->getUserByName($user->username);
        }
        catch (RunTimeException $e){
            $form->get('username')->setMessages(['Username does not exist']);
            return ['form' => $form];
        }

        if ($savedUser && $savedUser->password == $user->password ){
            return $this->redirect()->toRoute('cat');
        }

        $form->get('password')->setMessages(['Username and password do not match']);
        return ['form' => $form];
        
    }

    public function signUpAction()
    {
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
        try {
            $this->usertable->createUser($user);
        } 
        catch (RuntimeException $e)
        {
            $form->get('username')->setMessages(['Username is in use']);
            return ['form' => $form];
        }   
        return $this->redirect()->toRoute('cat');    
    }
}