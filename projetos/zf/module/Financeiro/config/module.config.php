<?php

 return array(
     'controllers' => array(
         'invokables' => array(
             'Financeiro\Controller\Financeiro' => 'Financeiro\Controller\FinanceiroController',
         ),
     ),

     // The following section is new and should be added to your file
     'router' => array(
         'routes' => array(
             'financeiro' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/financeiro[/:action][/:id]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[0-9]+'

                     ),
                     'defaults' => array(
                         'controller' => 'Financeiro\Controller\Financeiro',
                         'action'     => 'index',
                     ),
                 ),
             ),
         ),
     ),

     'view_manager' => array(
         'template_path_stack' => array(
             'financeiro' => __DIR__ . '/../view',
         ),
     ),
 );