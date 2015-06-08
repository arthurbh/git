<?php

 namespace Financeiro\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
 use Financeiro\Model\Financeiro;          // <-- Add this import
 use Financeiro\Form\FinanceiroForm;       // <-- Add this import

 use SanAuth\Controller;

 class FinanceiroController extends AbstractActionController
 {
 	 protected $FinanceiroTable;

     public function indexAction()
     {

       
        if(!$this->getServiceLocator()->get('AuthService')->hasIdentity())
        {
            return $this->redirect()->toRoute('login');
        }

         // grab the paginator from the AlbumTable
         $paginator = $this->getFinanceiroTable()->fetchAll(true);
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
         $form = new FinanceiroForm();
         $form->get('submit')->setValue('Add');

         $request = $this->getRequest();
         if ($request->isPost()) {
             $Financeiro = new Financeiro();
             $form->setInputFilter($Financeiro->getInputFilter());
             $form->setData($request->getPost());

             if ($form->isValid()) {
                 $Financeiro->exchangeArray($form->getData());
                 $this->getFinanceiroTable()->saveFinanceiro($Financeiro);

               return $this->redirect()->toRoute('Financeiro');
             }
         }
         return array('form' => $form);
     }

    
     public function editAction()
     {
         $id = (int) $this->params()->fromRoute('id', 0);
         if (!$id) {
             return $this->redirect()->toRoute('Financeiro', array(
                 'action' => 'add'
             ));
         }

          try {
             $Financeiro = $this->getFinanceiroTable()->getFinanceiro($id);
         }
         catch (\Exception $ex) {
             return $this->redirect()->toRoute('Financeiro', array(
                 'action' => 'index'
             ));
         }

         $form  = new FinanceiroForm();
         $form->bind($Financeiro);
         $form->get('submit')->setAttribute('value', 'Edit');

         $request = $this->getRequest();
         if ($request->isPost()) {
             $form->setInputFilter($Financeiro->getInputFilter());
             $form->setData($request->getPost());

             if ($form->isValid()) {
                 $this->getFinanceiroTable()->saveFinanceiro($Financeiro);

                 return $this->redirect()->toRoute('Financeiro');
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
             return $this->redirect()->toRoute('Financeiro');
         }

         $request = $this->getRequest();
         if ($request->isPost()) {
             $del = $request->getPost('del', 'No');

             if ($del == 'Yes') {
                 $id = (int) $request->getPost('id');
                 $this->getFinanceiroTable()->deleteFinanceiro($id);
             }

            return $this->redirect()->toRoute('Financeiro');
         }

         return array(
             'id'    => $id,
             'Financeiro' => $this->getFinanceiroTable()->getFinanceiro($id)
         );
     }

      public function getFinanceiroTable()
     {
         if (!$this->FinanceiroTable) {
             $sm = $this->getServiceLocator();
             $this->FinanceiroTable = $sm->get('Financeiro\Model\FinanceiroTable');
         }
         return $this->FinanceiroTable;
     }
 }