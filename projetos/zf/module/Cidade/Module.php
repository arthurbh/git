<?php

 namespace Cidade;

 use Cidade\Model\Cidade;
 use Cidade\Model\CidadeTable;
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
                 'Cidade\Model\CidadeTable' =>  function($sm) {
                     $tableGateway = $sm->get('CidadeTableGateway');
                     $table = new CidadeTable($tableGateway);
                     return $table;
                 },
                 'CidadeTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Cidade());
                     return new TableGateway('cidade', $dbAdapter, null, $resultSetPrototype);
                 },
             ),
         );
     }
 }