<?php

 namespace Cidade\Model;

  // Add these import statements
 use Zend\InputFilter\InputFilter;
 use Zend\InputFilter\InputFilterAwareInterface;
  use Zend\InputFilter\InputFilterInterface;

 class Cidade implements InputFilterAwareInterface
 {
     public     $id;
     public     $cidade;
     public     $fk_estado;
     protected  $inputFilter;                       // <-- Add this variable


     public function exchangeArray($data)
     {
            $this->id           = (!empty($data['id'])) ? $data['id'] : null;
            $this->cidade       = (!empty($data['cidade'])) ? $data['cidade'] : null;
            $this->fk_estado    = (!empty($data['fk_estado'])) ? $data['fk_estado'] : null;
         
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