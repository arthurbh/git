<?php

namespace Cliente\Form;

 use Zend\Form\Form;
 use Estado\Model\EstadoTable;

 class ClienteForm extends Form
 {
     public function __construct(EstadoTable $selectTable)
     {
         // we want to ignore the name passed

         parent::__construct('Cliente Form');


         $this->setSelectTable($selectTable);

         $this->add(array(
             'name' => 'id',
             'type' => 'Hidden',
         ));
         $this->add(array(
             'name' => 'title',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Title',
             ),
         ));
         $this->add(array(
             'name' => 'artist',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Artist',
             ),
         ));
         $this->add(array(
             'name' => 'submit',
             'type' => 'Submit',
             'attributes' => array(
                 'value' => 'Go',
                 'id' => 'submitbutton',
             ),
         ));

            $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'estado',
            'options' => array(
                'value_options' => $this->getOptionsForSelect(),
                'empty_option'   => 'ESTADO'
               ),
                    'attributes' => array(
                    'required'              => 'required',
                    'data-parsley-pattern'  => '/^[0-9]{1}$/',
                   'data-parsley-group'     =>'block1',
                    'value'                 => '' //set selected to '1'
                ),
        ));

     }


      private function setSelectTable($table)
     {
        $this->selectTable = $table;
     }

     private function getSelectTable()
     {
       return $this->selectTable;
     }


    public function getOptionsForSelect()
    {
            $table = $this->getSelectTable();
            $data  = $table->fetchAll();

            $selectData = array();

            foreach ($data as $selectOption) {
                $selectData[$selectOption->id] = $selectOption->estado;
            }

            return $selectData;
    }
 }

 