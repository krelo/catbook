<?php

namespace Home\Controller;

use Cat\Model\CatTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class HomeController extends AbstractActionController
{

    private $table;

    public function __construct(CatTable $table)
    {
        $this->table = $table;
    }

    public function indexAction()
    {
        return new ViewModel([
            'cats' => $this->table->fetchAll(),
        ]);
    }
}