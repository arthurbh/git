<?php

 return array(
     'controllers' => array(
         'invokables' => array(
             'Estado\Controller\Estado' => 'Estado\Controller\EstadoController',
         ),
     ),

     // The following section is new and should be added to your file
     'router' => array(
         'routes' => array(
             'estado' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/estado[/:action][/:id]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[0-9]+'

                     ),
                     'defaults' => array(
                         'controller' => 'Estado\Controller\Estado',
                         'action'     => 'index',
                     ),
                 ),
             ),
         ),
     ),

     'view_manager' => array(
         'template_path_stack' => array(
             'estado' => __DIR__ . '/../view',
         ),
     ),
 );