<?php

namespace Tarefas\Form;

 use Zend\Form\Form;
 use Zend\Form\Element;
 use Usuario\Model\UsuarioTable;
//use Zend\Db\Adapter\AdapterInterface;
//use Zend\Db\Adapter\Adapter;

 class TarefasForm extends Form
 {
    protected $selectTable;
     
     public function __construct(UsuarioTable $selectTable)
     {
         // we want to ignore the name passed
         $this->setSelectTable($selectTable);


         parent::__construct('Tarefas Form');

         $this->setAttribute('method', 'post');
         

         $this->add(array(
             'name' => 'id',
             'type' => 'Hidden',
         ));
         $this->add(array(
             'name' => 'titulo',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Título',
             ),
         ));


        $this->add(array(
            'name' => 'descricao',
            'attributes'=>array(
                'type'=>'textarea' 
            ),
            'options' => array(
                'label' => 'Descrição',
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'fk_responsavel',
            'options' => array(
                'label' => 'Responsavel',
                'value_options' => $this->getOptionsForSelect(),
                'empty_option'   => '--- Responsável ---'
               ),
                    'attributes' => array(
                    'value' => '' //set selected to '1'
                ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Date',
            'name' => 'data_inicio',
            'options' => array(
                'label' => 'Data Inicial'
            )
        ));

       

        $this->add(array(
            'type' => 'Zend\Form\Element\Date',
            'name' => 'data_fim',
            'options' => array(
                'label' => 'Data Final'
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'prioridade',
            'options' => array(
                'label' => 'Prioridade',
                'value_options' => array('1' => 'Baixa', '2' => 'Media', '3' => 'Alta', '4' => 'Urgente'),
               ),
                  
        ));

            
       /* OUTROS ATRIBUTOS
    
      $this->add(array(
             'name' => 'phone',
             'type' => 'Application\Form\Element\Phone',
              'options' => array(
                'label' => 'Telefone'
            )
         ));

         $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'gender',
            'options' => array(
                'label' => 'Gender',
                'value_options' => array(
                    '1' => 'Select your gender',
                    '2' => 'Female',
                    '3' => 'Male'
                ),
            ),
            'attributes' => array(
                'value' => '1' //set selected to '1'
            )
        ));
         
        $this->add(array(
            'type' => 'Zend\Form\Element\MultiCheckbox',
            'name' => 'hobby',
            'options' => array(
                'label' => 'Please choose one/more of the hobbies',
                'value_options' => array(
                    '1' =>'Cooking',
                    '2'=>'Writing',
                    '3'=>'Others'
                ),
            ),
            'attributes' => array(
                'value' => '1' //set checked to '1'
            )
        ));
         
        $this->add(array(
            'type' => 'Zend\Form\Element\Email',
            'name' => 'email',
            'options' => array(
                'label' => 'Email'
            ),
            'attributes' => array(
                'placeholder' => 'you@domain.com'
            )
        ));
  
        $this->add(array(
            'type' => 'Zend\Form\Element\Date',
            'name' => 'birth',
            'options' => array(
                'label' => 'Birth'
            )
        ));
         
        $this->add(array(
            'name' => 'address',
            'attributes'=>array(
                'type'=>'textarea' 
            ),
            'options' => array(
                'label' => 'Address',
            ),
        ));
         
        $this->add(array(
            'type' => 'Zend\Form\Element\Radio',
            'name' => 'direction',
            'options' => array(
                'label' => 'Please choose one of the directions',
                'value_options' => array(
                    '1' => 'Programming',
                    '2' => 'Design',
                ),
            ),
            'attributes' => array(
                'value' => '1' //set checked to '1'
            )
        ));
       */

    
         $this->add(array(
             'name' => 'submit',
             'type' => 'Submit',
             'attributes' => array(
                 'value' => 'Go',
                 'id' => 'submitbutton',
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
                $selectData[$selectOption->id] = $selectOption->usuario;
            }

            return $selectData;
    }
    /*
       public function getOptionsForSelect()
    {
        $dbAdapter = $this->adapter;
        $sql       = 'SELECT id,usuario FROM usuario ORDER BY usuario ASC';
        $statement = $dbAdapter->query($sql);
        $result    = $statement->execute();

        $selectData = array();

        foreach ($result as $res) {
            $selectData[$res['id']] = $res['usuario'];
        }
        return $selectData;
    }

    */
 }

 