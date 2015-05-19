<?php

 return array(
     'controllers' => array(
         'invokables' => array(
             'Tarefas\Controller\Tarefas' => 'Tarefas\Controller\TarefasController',
         ),
     ),
      'form_elements' => array(
        'invokables' => array(
            'phone' => 'Application\Form\Element\Phone'
        ),
    ),

     // The following section is new and should be added to your file
     'router' => array(
         'routes' => array(
             'tarefas' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/tarefas[/:action][/:id]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[0-9]+'

                     ),
                     'defaults' => array(
                         'controller' => 'Tarefas\Controller\Tarefas',
                         'action'     => 'index',
                     ),
                 ),
             ),
         ),
     ),

     'view_manager' => array(
         'template_path_stack' => array(
             'tarefas' => __DIR__ . '/../view',
         ),
     ),
 );