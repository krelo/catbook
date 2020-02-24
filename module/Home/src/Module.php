<?php

namespace Home;

use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Cat\Model\CatTable;
use User\Model\UserTable;
use User\Model\UserAuthAdapter;
use Zend\Authentication\AuthenticationService;

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
                         $container->get(CatTable::class),
                         $container->get(UserTable::class),
                         $container->get(AuthenticationService::class),
                     );
                 },
             ],
         ];
     }
}