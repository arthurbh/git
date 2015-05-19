<?php

 namespace Tarefas\Controller;


 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
 use Tarefas\Model\Tarefas;          // <-- Add this import
 use Tarefas\Form\TarefasForm;       // <-- Add this import
 use Usuario\Model\UsuarioTable; 
 use SanAuth\Controller;

 class TarefasController extends AbstractActionController
 {
 	 protected $tarefasTable;

     public function indexAction()
     {

        if(!$this->getServiceLocator()->get('AuthService')->hasIdentity())
        {
            return $this->redirect()->toRoute('login');
        }

         // grab the paginator from the TarefasTable
         $paginator = $this->getTarefasTable()->fetchAll(true);
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

        //$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
         $dbAdapter = $this->getServiceLocator()->get('Usuario\Model\UsuarioTable');
         $form      = new TarefasForm($dbAdapter);

         $form->get('submit')->setValue('Add');

         $request = $this->getRequest();
         if ($request->isPost()) {
             $tarefas = new Tarefas();
             $form->setInputFilter($tarefas->getInputFilter());

             $form->setData($request->getPost());

             if ($form->isValid()) {
                 $tarefas->exchangeArray($form->getData());
                 $this->getTarefasTable()->saveTarefas($tarefas);

                 // Redirect to list of tarefass
                 return $this->redirect()->toRoute('tarefas');
             }
         }
         return array('form' => $form);
     }

    
     public function editAction()
     {
         $id = (int) $this->params()->fromRoute('id', 0);
         if (!$id) {
             return $this->redirect()->toRoute('tarefas', array(
                 'action' => 'add'
             ));
         }

         // Get the Tarefas with the specified id.  An exception is thrown
         // if it cannot be found, in which case go to the index page.
         try {
             $tarefas = $this->getTarefasTable()->getTarefas($id);
         }
         catch (\Exception $ex) {
             return $this->redirect()->toRoute('tarefas', array(
                 'action' => 'index'
             ));
         }

         $form  = new TarefasForm();
         $form->bind($tarefas);
         $form->get('submit')->setAttribute('value', 'Edit');

         $request = $this->getRequest();
         if ($request->isPost()) {
             $form->setInputFilter($tarefas->getInputFilter());
             $form->setData($request->getPost());

             if ($form->isValid()) {
                 $this->getTarefasTable()->saveTarefas($tarefas);

                 // Redirect to list of tarefass
                 return $this->redirect()->toRoute('tarefas');
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
             return $this->redirect()->toRoute('tarefas');
         }

         $request = $this->getRequest();
         if ($request->isPost()) {
             $del = $request->getPost('del', 'No');

             if ($del == 'Yes') {
                 $id = (int) $request->getPost('id');
                 $this->getTarefasTable()->deleteTarefas($id);
             }

             // Redirect to list of tarefass
             return $this->redirect()->toRoute('tarefas');
         }

         return array(
             'id'    => $id,
             'tarefas' => $this->getTarefasTable()->getTarefas($id)
         );
     }

      public function getTarefasTable()
     {
         if (!$this->tarefasTable) {
             $sm = $this->getServiceLocator();
             $this->tarefasTable = $sm->get('Tarefas\Model\TarefasTable');
         }
         return $this->tarefasTable;
     }
 }