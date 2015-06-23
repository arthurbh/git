<?php

 namespace Usuario\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
 use Usuario\Model\Usuario;          // <-- Add this import
 use Usuario\Form\UsuarioForm;       // <-- Add this import

 use SanAuth\Controller;

 class UsuarioController extends AbstractActionController
 {
 	 protected $usuarioTable;

     public function indexAction()
     {

       
        if(!$this->getServiceLocator()->get('AuthService')->hasIdentity())
        {
            return $this->redirect()->toRoute('login');
        }

         // grab the paginator from the AlbumTable
         $paginator = $this->getUsuarioTable()->fetchAll(true);
         // set the current page to what has been passed in query string, or to 1 if none set
         $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
         // set the number of items per page to 10
         $paginator->setItemCountPerPage(10);

         return new ViewModel(array(
             'paginator' => $paginator
         ));

      
     }

     public function addAction()
     {
         $form = new UsuarioForm();
         $form->get('submit')->setValue('Add');

         $request = $this->getRequest();
         if ($request->isPost()) {
             $usuario = new Usuario();
             $form->setInputFilter($usuario->getInputFilter());
             $form->setData($request->getPost());

             if ($form->isValid()) {
                 $usuario->exchangeArray($form->getData());
                 $this->getUsuarioTable()->saveUsuario($usuario);

               return $this->redirect()->toRoute('usuario');
             }
         }
         return array('form' => $form);
     }

    
     public function editAction()
     {
         $id = (int) $this->params()->fromRoute('id', 0);
         if (!$id) {
             return $this->redirect()->toRoute('usuario', array(
                 'action' => 'add'
             ));
         }

          try {
             $usuario = $this->getUsuarioTable()->getUsuario($id);
         }
         catch (\Exception $ex) {
             return $this->redirect()->toRoute('usuario', array(
                 'action' => 'index'
             ));
         }

         $form  = new UsuarioForm();
         $form->bind($usuario);
         $form->get('submit')->setAttribute('value', 'Edit');

         $request = $this->getRequest();
         if ($request->isPost()) {
             $form->setInputFilter($usuario->getInputFilter());
             $form->setData($request->getPost());

             if ($form->isValid()) {
                 $this->getUsuarioTable()->saveUsuario($usuario);

                 return $this->redirect()->toRoute('usuario');
             }
         }

         return array(
             'id' => $id,
             'form' => $form,
         );
     }
     

     public function deleteAction()
     {
         $id = (int) $this->params()->fromRoute('id', 0);
         if (!$id) {
             return $this->redirect()->toRoute('usuario');
         }

         $request = $this->getRequest();
         if ($request->isPost()) {
             $del = $request->getPost('del', 'No');

             if ($del == 'Yes') {
                 $id = (int) $request->getPost('id');
                 $this->getUsuarioTable()->deleteUsuario($id);
             }

            return $this->redirect()->toRoute('usuario');
         }

         return array(
             'id'    => $id,
             'usuario' => $this->getUsuarioTable()->getUsuario($id)
         );
     }

      public function getUsuarioTable()
     {
         if (!$this->usuarioTable) {
             $sm = $this->getServiceLocator();
             $this->usuarioTable = $sm->get('Usuario\Model\UsuarioTable');
         }
         return $this->usuarioTable;
     }
 }