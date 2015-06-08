<?php

 namespace Financeiro;

 use Financeiro\Model\Financeiro;
 use Financeiro\Model\FinanceiroTable;
 use Zend\Db\ResultSet\ResultSet;
 use Zend\Db\TableGateway\TableGateway;

 use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
 use Zend\ModuleManager\Feature\ConfigProviderInterface;

 class Module implements AutoloaderProviderInterface, ConfigProviderInterface
 {
     public function getAutoloaderConfig()
     {
         return array(
             'Zend\Loader\ClassMapAutoloader' => array(
                 __DIR__ . '/autoload_classmap.php',
             ),
             'Zend\Loader\StandardAutoloader' => array(
                 'namespaces' => array(
                     __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                 ),
             ),
         );
     }

     public function getConfig()
     {
         return include __DIR__ . '/config/module.config.php';
     }

      public function getServiceConfig()
     {
         return array(
             'factories' => array(
                 'Financeiro\Model\FinanceiroTable' =>  function($sm) {
                     $tableGateway = $sm->get('FinanceiroTableGateway');
                     $table = new FinanceiroTable($tableGateway);
                     return $table;
                 },
                 'FinanceiroTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Financeiro());
                     return new TableGateway('album', $dbAdapter, null, $resultSetPrototype);
                 },
             ),
         );
     }
 }