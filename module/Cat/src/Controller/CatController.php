<?php

namespace Cat\Controller;

use Cat\Model\CatTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Cat\Form\CatForm;
use Cat\Model\Cat;
use Zend\Authentication\AuthenticationService;
use RuntimeException;

class CatController extends AbstractActionController
{
    private $table;
    private $auth;

    public function __construct(CatTable $table)
    {
        $this->table = $table;
        $this->auth = new AuthenticationService();
    }

    public function indexAction()
    {
        if (!$this->auth->hasIdentity()){
            return $this->redirect()->toRoute('home', ['action' => 'signin']);
        }

        $userId = $this->auth->getIdentity();

        return new ViewModel([
            'cats' => $this->table->fetchByUser($userId),
        ]);
    }

    public function addAction()
    {
        if (!$this->auth->hasIdentity()){
            return $this->redirect()->toRoute('home', ['action' => 'signin']);
        }
        $userId = $this->auth->getIdentity();

        $form = new CatForm();
        $form->get('submit')->setValue('Add');
        $form->get('owner_id')->setValue($userId);

        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }

     
        $cat = new Cat();
        $form->setInputFilter($cat->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $data = $form->getData();

        $cat->exchangeArray($form->getData());
        $this->table->saveCat($cat);
        return $this->redirect()->toRoute('cat');
    }

    public function editAction()
    {
        if (!$this->auth->hasIdentity()){
            return $this->redirect()->toRoute('home', ['action' => 'signin']);
        }

        $id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('cat', ['action' => 'add']);
        }

        // Retrieve the cat with the specified id. Doing so raises
        // an exception if the cat is not found, which should result
        // in redirecting to the landing page.
        try {
            $cat = $this->table->getCat($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('cat', ['action' => 'index']);
        }

        $form = new CatForm();
        $form->bind($cat);
        $form->get('submit')->setAttribute('value', 'Edit');
        

        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($cat->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        $this->table->saveCat($cat);

        // Redirect to cat list
        return $this->redirect()->toRoute('cat', ['action' => 'index']);
    }

    public function deleteAction()
    {
        if (!$this->auth->hasIdentity()){
            return $this->redirect()->toRoute('home', ['action' => 'signin']);
        }
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('cat');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->table->deleteCat($id);
            }

            // Redirect to list of cats
            return $this->redirect()->toRoute('cat');
        }

        return [
            'id'    => $id,
            'cat' => $this->table->getCat($id),
        ];
    }
}