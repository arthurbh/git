<?php

namespace Tarefas\Model;

 use Zend\Db\ResultSet\ResultSet;
 use Zend\Db\TableGateway\TableGateway;
 use Zend\Db\Sql\Select;
 use Zend\Paginator\Adapter\DbSelect;
 use Zend\Paginator\Paginator;

 class TarefasTable
 {
     protected $tableGateway;

     public function __construct(TableGateway $tableGateway)
     {
         $this->tableGateway = $tableGateway;
     }

    public function fetchAll($paginated=false)
     {
         if ($paginated) {
             // create a new Select object for the table tarefas
             $select = new Select('tarefas');
             // create a new result set based on the Tarefas entity
             $resultSetPrototype = new ResultSet();
             $resultSetPrototype->setArrayObjectPrototype(new Tarefas());
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

     public function getTarefas($id)
     {
         $id  = (int) $id;
         $rowset = $this->tableGateway->select(array('id' => $id));
         $row = $rowset->current();
         if (!$row) {
             throw new \Exception("Could not find row $id");
         }
         return $row;
     }

     public function saveTarefas(Tarefas $tarefas)
     {
         $data = array(

             'fk_responsavel' => (int)$tarefas->fk_responsavel,
             'titulo'       => $tarefas->titulo,
             'descricao'    => $tarefas->descricao,
             'data_inicio'  => $tarefas->data_inicio,
             'data_fim'     => $tarefas->data_fim,
             'prioridade'   => $tarefas->prioridade
         );

         $id = (int) $tarefas->id;
         if ($id == 0) {
             $this->tableGateway->insert($data);
         } else {
             if ($this->getTarefas($id)) {
                 $this->tableGateway->update($data, array('id' => $id));
             } else {
                 throw new \Exception('Tarefas id does not exist');
             }
         }
     }

     public function deleteTarefas($id)
     {
         $this->tableGateway->delete(array('id' => (int) $id));
     }
 }