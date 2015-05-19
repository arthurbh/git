<?php

 return array(
     'controllers' => array(
         'invokables' => array(
             'Cliente\Controller\Cliente' => 'Cliente\Controller\ClienteController',
         ),
     ),

     // The following section is new and should be added to your file
     'router' => array(
         'routes' => array(
             'cliente' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/cliente[/:action][/:id]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[0-9]+'

                     ),
                     'defaults' => array(
                         'controller' => 'Cliente\Controller\Cliente',
                         'action'     => 'index',
                     ),
                 ),
             ),
         ),
     ),

     'view_manager' => array(
         'template_path_stack' => array(
             'cliente' => __DIR__ . '/../view',
         ),
     ),
 );