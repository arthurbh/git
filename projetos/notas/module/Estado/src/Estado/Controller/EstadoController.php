<?php

 namespace Estado\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
 use Estado\Model\Estado;          // <-- Add this import


 use SanAuth\Controller;

 class EstadoController extends AbstractActionController
 {
 	
    protected $estadoTable;

    public function indexAction()
    {

        if(!$this->getServiceLocator()->get('AuthService')->hasIdentity())
        {
            return $this->redirect()->toRoute('login');
        }

         // grab the paginator from the AlbumTable
         

         $view      =  new ViewModel(array('estados' => $estados));

         
         $view->setTemplate('estado/index.phtml');
       
         return  $view;  
    }

    public function getAllEstados()
    {
        $estados   = $this->getEstadoTable()->fetchAll();
        return $estados;
    }


  

     public function getEstadoTable()
     {
         if (!$this->estadoTable) {
             $sm = $this->getServiceLocator();
             $this->estadoTable = $sm->get('Estado\Model\EstadoTable');
         }
         return $this->estadoTable;
     }
 }