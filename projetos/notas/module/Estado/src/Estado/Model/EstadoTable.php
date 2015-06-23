<?php

namespace Estado\Model;

 use Zend\Db\ResultSet\ResultSet;
 use Zend\Db\TableGateway\TableGateway;
 use Zend\Db\Sql\Select;

 class EstadoTable
 {
     protected $tableGateway;

     public function __construct(TableGateway $tableGateway)
     {
         $this->tableGateway = $tableGateway;
     }

 

     public function fetchAll()
     {
        
         $resultSet = $this->tableGateway->select();
         return $resultSet;
     }

     public function getEstado($id)
     {
         $id  = (int) $id;
         $rowset = $this->tableGateway->select(array('id' => $id));
         $row = $rowset->current();
         if (!$row) {
             throw new \Exception("Could not find row $id");
         }
         return $row;
     }

     public function saveEstado(Estado $estado)
     {
         $data = array(
             'artist' => $estado->artist,
             'title'  => $estado->title,
         );

         $id = (int) $estado->id;
         if ($id == 0) {
             $this->tableGateway->insert($data);
         } 
         else {
            
             if ($this->getEstado($id)) {
                 $this->tableGateway->update($data, array('id' => $id));
             } else {
                 throw new \Exception('estado id does not exist');
             }
         }
     }

     public function deleteEstado($id)
     {
         $this->tableGateway->delete(array('id' => (int) $id));
     }
 }