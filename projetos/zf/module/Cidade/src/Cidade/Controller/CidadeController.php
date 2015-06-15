<?php

 namespace Cidade\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
 use Cidade\Model\Cidade;          // <-- Add this import


 use SanAuth\Controller;

 class CidadeController extends AbstractActionController
 {
 	
    protected $cidadeTable;

    public function indexAction()
    {

        if(!$this->getServiceLocator()->get('AuthService')->hasIdentity())
        {
            return $this->redirect()->toRoute('login');
        }

         // grab the paginator from the AlbumTable
         
        $view      =  new ViewModel(array('cidades' => array()));

         
         $view->setTemplate('cidade/index.phtml');
       
         return  $view;  
    }

    public function buscaporestadoAction()
    {

        $idestado = (int) $this->params()->fromRoute('id', 0);

        $cidades   = $this->getAllCidades($idestado);

         $view      =  new ViewModel(array('cidades' => $cidades));
         $view->setTerminal(true);
         $view->setTemplate('cidade/buscaporestado.phtml');
       
         return  $view;  
    }

    public function getAllCidades()
    {
        $cidades   = $this->getCidadeTable()->fetchAll();
        return $cidades;
    }

    public function getCidadebyEstado($id)
    {
        $cidades   = $this->getbyEstado($id)->fetchAll();
        return $cidades;
    }


  

     public function getCidadeTable()
     {
         if (!$this->cidadeTable) {
             $sm = $this->getServiceLocator();
             $this->cidadeTable = $sm->get('Cidade\Model\CidadeTable');
         }
         return $this->cidadeTable;
     }
 }