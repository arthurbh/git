<?php

namespace Financeiro\Model;

 use Zend\Db\ResultSet\ResultSet;
 use Zend\Db\TableGateway\TableGateway;
 use Zend\Db\Sql\Select;
 use Zend\Paginator\Adapter\DbSelect;
 use Zend\Paginator\Paginator;
 
 class FinanceiroTable
 {
     protected $tableGateway;

     public function __construct(TableGateway $tableGateway)
     {
         $this->tableGateway = $tableGateway;
     }

 

       public function fetchAll($paginated=false)
     {
         if ($paginated) {
           
             $select = new Select('album');
             $resultSetPrototype = new ResultSet();
             $resultSetPrototype->setArrayObjectPrototype(new Financeiro());
             // create a new pagination adapter object
             $paginatorAdapter = new DbSelect(
                 // our configured select object
                 $select,
                 // the adapter to run it against
                 $this->tableGateway->getAdapter(),
                 // the result set to hydrate
                 $resultSetPrototype
             );
             $paginator = new Paginator($paginatorAdapter);
             return $paginator;
         }
         $resultSet = $this->tableGateway->select();
         return $resultSet;
     }

     public function getFinanceiro($id)
     {
         $id  = (int) $id;
         $rowset = $this->tableGateway->select(array('id' => $id));
         $row = $rowset->current();
         if (!$row) {
             throw new \Exception("Could not find row $id");
         }
         return $row;
     }

     public function saveFinanceiro(Financeiro $Financeiro)
     {
         $data = array(
             'artist' => $Financeiro->artist,
             'title'  => $Financeiro->title,
         );

         $id = (int) $Financeiro->id;
         if ($id == 0) {
             $this->tableGateway->insert($data);
         } else {
             if ($this->getFinanceiro($id)) {
                 $this->tableGateway->update($data, array('id' => $id));
             } else {
                 throw new \Exception('Financeiro id does not exist');
             }
         }
     }

     public function deleteFinanceiro($id)
     {
         $this->tableGateway->delete(array('id' => (int) $id));
     }
 }