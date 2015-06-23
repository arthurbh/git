<?php

namespace Cidade\Model;

 use Zend\Db\ResultSet\ResultSet;
 use Zend\Db\TableGateway\TableGateway;
 use Zend\Db\Sql\Select;

 class CidadeTable
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

     public function getCidade($id)
     {
         $id  = (int) $id;
         $rowset = $this->tableGateway->select(array('id' => $id));
         $row = $rowset->current();
         if (!$row) {
             throw new \Exception("Could not find row $id");
         }
         return $row;
     }

     public function getbyEstado($idEstado)
     {
         $id  = (int)$idEstado;
         $rowset = $this->tableGateway->select(array('fk_estado' => $idEstado));
         $row = $rowset->current();
         if (!$row) {
             throw new \Exception("Could not find row $idEstado");
         }
         return $row;
     }

     public function saveCidade(Cidade $cidade)
     {
         $data = array(
             'artist' => $cidade->artist,
             'title'  => $cidade->title,
         );

         $id = (int) $cidade->id;
         if ($id == 0) {
             $this->tableGateway->insert($data);
         } 
         else {
            
             if ($this->getCidade($id)) {
                 $this->tableGateway->update($data, array('id' => $id));
             } else {
                 throw new \Exception('cidade id does not exist');
             }
         }
     }

     public function deleteCidade($id)
     {
         $this->tableGateway->delete(array('id' => (int) $id));
     }
 }