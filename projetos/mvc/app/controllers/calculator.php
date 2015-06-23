<?php 
  class Calculator extends Controller
  {   
    /**
    * Soma dois valores
    *
    * @param float $n1
    * @param float $n2
    * @return float
    */

    private $webservice = null;

    protected $server;


    public function somar($n1,$n2)
    {

       $teste =  $this->ws_soap->soma($n1,$n2);
    
        var_dump($teste);
    
    }
}
