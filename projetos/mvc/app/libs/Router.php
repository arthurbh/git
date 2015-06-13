<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Router
{
   
    
    public function __construct() {
        //construct
    }

    static $rotas = [];
   
    
    static function Rota($array =  array())
    {
        $result = array();
        
        if(count($array) > 0 and is_array($array))
        {
            /*
             * Matchs router
             */
            //outros parametros que serão colocados aqui depois
            $result = $array;
        }

        self::setRota($result);

    }

        static function getRota()
        {
            return self::$rotas;
        }
        

        static function setRota($resultRouter)
        {

            if(is_array($resultRouter) and count($resultRouter) > 0)
               self::$rotas[] = $resultRouter;
        }


        static function findRota($find)
        {   
            $find               = trim($find);

            $busca              = false;
            $rotaencontrada     = null;

            foreach (self::$rotas as $indice) {


               
                if(array_key_exists($find, $indice) and $busca === false)
                {

                  
                    $rotaencontrada     = $indice[$find];
                    $busca              = true;
                   
                }
            }

            return $rotaencontrada;
           
                
        }   
        
}

