<?php

 namespace Estado;

 use Estado\Model\Estado;
 use Estado\Model\EstadoTable;
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
                 'Estado\Model\EstadoTable' =>  function($sm) {
                     $tableGateway = $sm->get('EstadoTableGateway');
                     $table = new EstadoTable($tableGateway);
                     return $table;
                 },
                 'EstadoTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Estado());
                     return new TableGateway('estado', $dbAdapter, null, $resultSetPrototype);
                 },
             ),
         );
     }
 }