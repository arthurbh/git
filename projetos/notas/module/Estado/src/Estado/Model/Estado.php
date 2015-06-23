<?php

 namespace Estado\Model;

  // Add these import statements
 use Zend\InputFilter\InputFilter;
 use Zend\InputFilter\InputFilterAwareInterface;
  use Zend\InputFilter\InputFilterInterface;

 class Estado implements InputFilterAwareInterface
 {
     public     $id;
     public     $estado;
     public     $uf;
     protected  $inputFilter;                       // <-- Add this variable


     public function exchangeArray($data)
     {
         $this->id     = (!empty($data['id'])) ? $data['id'] : null;
         $this->uf     = (!empty($data['uf'])) ? $data['uf'] : null;
         $this->estado = (!empty($data['estado'])) ? $data['estado'] : null;
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

             $this->inputFilter = $inputFilter;
         }

         return $this->inputFilter;
     }
 }