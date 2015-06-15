<?php

 return array(
     'controllers' => array(
         'invokables' => array(
             'Cidade\Controller\Cidade' => 'Cidade\Controller\CidadeController',
         ),
     ),

     // The following section is new and should be added to your file
     'router' => array(
         'routes' => array(
             'cidade' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/cidade[/:action][/:id]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[0-9]+'

                     ),
                     'defaults' => array(
                         'controller' => 'Cidade\Controller\Cidade',
                         'action'     => 'index',
                     ),
                 ),
             ),
         ),
     ),


     

     'view_manager' => array(
         'template_path_stack' => array(
             'cidade' => __DIR__ . '/../view',
         ),
     ),
 );