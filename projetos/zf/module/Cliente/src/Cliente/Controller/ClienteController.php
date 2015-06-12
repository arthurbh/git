<?php

 namespace Cliente\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
 use Cliente\Model\Cliente;          // <-- Add this import
 use Cliente\Form\ClienteForm;       // <-- Add this import

 use SanAuth\Controller;
 use Estado\Controller\EstadoController;

 class ClienteController extends AbstractActionController
 {
 	 protected $clienteTable;

     public function indexAction()
     {
       
        if(!$this->getServiceLocator()->get('AuthService')->hasIdentity())
        {
            return $this->redirect()->toRoute('login');
        }

         // grab the paginator from the AlbumTable
         $paginator = $this->getClienteTable()->fetchAll(true);
         // set the current page to what has been passed in query string, or to 1 if none set
         $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
         // set the number of items per page to 10
         $paginator->setItemCountPerPage(10);

         $view =  new ViewModel(array(
             'paginator' => $paginator
         ));

         /*
        
         return new 
         */
         //setando a view
         $view->setTemplate('cliente/index.phtml');
       
         return  $view;

      
     }

     public function addAction()
     {

         
         $form = new ClienteForm();
         $form->get('submit')->setValue('Add');

         $request = $this->getRequest();
         if ($request->isPost()) {
             $cliente = new Cliente();
             $form->setInputFilter($cliente->getInputFilter());
             $form->setData($request->getPost());

             if ($form->isValid()) {
                 $cliente->exchangeArray($form->getData());
                 $this->getClienteTable()->saveCliente($cliente);

               return $this->redirect()->toRoute('cliente');
             }
         }


         return array('form' => $form,'estado' => array());

         //return new ViewModel();
     }

    
     public function editAction()
     {
         $id = (int) $this->params()->fromRoute('id', 0);
         if (!$id) {
             return $this->redirect()->toRoute('cliente', array(
                 'action' => 'add'
             ));
         }

          try {
             $cliente = $this->getClienteTable()->getCliente($id);
         }
         catch (\Exception $ex) {
             return $this->redirect()->toRoute('cliente', array(
                 'action' => 'index'
             ));
         }

         $form  = new ClienteForm();
         $form->bind($cliente);
         $form->get('submit')->setAttribute('value', 'Edit');

         $request = $this->getRequest();
         if ($request->isPost()) {
             $form->setInputFilter($cliente->getInputFilter());
             $form->setData($request->getPost());

             if ($form->isValid()) {
                 $this->getClienteTable()->saveCliente($cliente);

                 return $this->redirect()->toRoute('cliente');
             }
         }

         return array(
             'id'   => $id,
             'form' => $form,
         );
     }
     

     public function deleteAction()
     {
         $id = (int) $this->params()->fromRoute('id', 0);
         if (!$id) {
             return $this->redirect()->toRoute('cliente');
         }

         $request = $this->getRequest();
         if ($request->isPost()) {
             $del = $request->getPost('del', 'No');

             if ($del == 'Yes') {
                 $id = (int) $request->getPost('id');
                 $this->getClienteTable()->deleteCliente($id);
             }

            return $this->redirect()->toRoute('cliente');
         }

         return array(
             'id'    => $id,
             'cliente' => $this->getClienteTable()->getCliente($id)
         );
     }

      public function getClienteTable()
     {
         if (!$this->clienteTable) {
             $sm = $this->getServiceLocator();
             $this->clienteTable = $sm->get('Cliente\Model\ClienteTable');
         }
         return $this->clienteTable;
     }
 }