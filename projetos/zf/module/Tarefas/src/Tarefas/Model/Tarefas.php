<?php

 namespace Tarefas\Model;

  // Add these import statements
 use Zend\InputFilter\InputFilter;
 use Zend\InputFilter\InputFilterAwareInterface;
 use Zend\InputFilter\InputFilterInterface;

 class Tarefas implements InputFilterAwareInterface
 {
     public $id;
     public $fk_responsavel;
     public $titulo;
     public $descricao;
     public $data_inicio;
     public $data_fim;
     public $prioridade;

     protected $inputFilter;                       // <-- Add this variable


     public function exchangeArray($data)
     {
         $this->id     = (!empty($data['id'])) ? $data['id'] : null;
         $this->fk_responsavel = (!empty($data['fk_responsavel'])) ? (int)$data['fk_responsavel'] : null;
         $this->titulo  = (!empty($data['titulo'])) ? $data['titulo'] : null;
         $this->descricao  = (!empty($data['descricao'])) ? $data['descricao'] : null;
         $this->data_inicio  = (!empty($data['data_inicio'])) ? $data['data_inicio'] : null;
         $this->data_fim  = (!empty($data['data_fim'])) ? $data['data_fim'] : null;
         $this->prioridade  = (!empty($data['prioridade'])) ? $data['prioridade'] : null;
     }

     public function getArrayCopy()
     {
         return get_object_vars($this);
     }

         // Add content to these methods:
     public function setInputFilter(InputFilterInterface $inputFilter)
     {
         throw new \Exception("Not used");
     }



public function getInputFilter()
     {
         if (!$this->inputFilter) {
             $inputFilter = new InputFilter();

             $inputFilter->add(array(
                 'name'     => 'id',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'Int'),
                 ),
             ));

             $inputFilter->add(array(
                 'name'     => 'fk_responsavel',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'Int'),
                 ),
               
             ));

             $inputFilter->add(array(
                 'name'     => 'titulo',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
                 'validators' => array(
                     array(
                         'name'    => 'StringLength',
                         'options' => array(
                             'encoding' => 'UTF-8',
                             'min'      => 1,
                             'max'      => 100,
                         ),
                     ),
                 ),
             ));



              $inputFilter->add(array(
                 'name'     => 'data_inicio',
                 'required' => true,
                 'filters'  => array(
                         array('name' => 'StringTrim'),
                 ),
                 'validators' => array(
                     array(
                         'name'    => 'StringLength',
                         'options' => array(
                             'encoding' => 'UTF-8',
                             'min'      => 10,
                             'max'      => 10,
                         ),
                     ),
                 ),
             ));

                $inputFilter->add(array(
                 'name'     => 'data_fim',
                 'required' => true,
                 'filters'  => array(
                         array('name' => 'StringTrim'),
                 ),
                 'validators' => array(
                     array(
                         'name'    => 'StringLength',
                         'options' => array(
                             'encoding' => 'UTF-8',
                             'min'      => 10,
                             'max'      => 10,
                         ),
                     ),
                 ),
             ));


             $inputFilter->add(array(
                 'name'     => 'prioridade',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'Int'),
                 ),
               
             ));


             $this->inputFilter = $inputFilter;
         }

         return $this->inputFilter;
     }
 }