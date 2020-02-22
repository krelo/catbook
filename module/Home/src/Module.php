<?php

namespace Home;

use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Cat\Model\CatTable;

class Module implements ConfigProviderInterface
{
     public function getConfig()
     {
        return include __DIR__ . '/../config/module.config.php';
     }

     public function getControllerConfig()
     {
         return [
             'factories' => [
                 Controller\HomeController::class => function($container) {
                     return new Controller\HomeController(
                         $container->get(CatTable::class)
                     );
                 },
             ],
         ];
     }
}