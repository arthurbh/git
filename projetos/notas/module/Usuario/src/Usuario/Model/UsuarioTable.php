<?php

namespace Usuario\Model;

 use Zend\Db\ResultSet\ResultSet;
 use Zend\Db\TableGateway\TableGateway;
 use Zend\Db\Sql\Select;
 use Zend\Paginator\Adapter\DbSelect;
 use Zend\Paginator\Paginator;
 
 class UsuarioTable
 {
     protected $tableGateway;

     public function __construct(TableGateway $tableGateway)
     {
         $this->tableGateway = $tableGateway;
     }

 

       public function fetchAll($paginated=false)
     {
         if ($paginated) {
           
             $select = new Select('usuario');
             $resultSetPrototype = new ResultSet();
             $resultSetPrototype->setArrayObjectPrototype(new Usuario());
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

     public function getUsuario($id)
     {
         $id  = (int) $id;
         $rowset = $this->tableGateway->select(array('id' => $id));
         $row = $rowset->current();
         if (!$row) {
             throw new \Exception("Could not find row $id");
         }
         return $row;
     }

     public function saveUsuario(Usuario $cliente)
     {
         $data = array(
             'artist' => $cliente->artist,
             'title'  => $cliente->title,
         );

         $id = (int) $cliente->id;
         if ($id == 0) {
             $this->tableGateway->insert($data);
         } else {
             if ($this->getUsuario($id)) {
                 $this->tableGateway->update($data, array('id' => $id));
             } else {
                 throw new \Exception('cliente id does not exist');
             }
         }
     }

     public function deleteUsuario($id)
     {
         $this->tableGateway->delete(array('id' => (int) $id));
     }
 }