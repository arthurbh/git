<?php


class WebService
{
	
	public static $instancia    = null;
	private $conectado 			= false;
	private $soap;

	private $pathws 		    = 'http://localhost/projetos/mvc/app/webservice.wsdl';
	private $class 				= null;


	public static function getInstance()
    {

    	WebService::$instancia = (is_null(WebService::$instancia)) ? new WebService() : WebService::$instancia;
     
        return WebService::$instancia;
   
    }

    private function comunica()
    {
        if (!$this->conectado)
        {
            $this->soap 		= new SoapClient($this->pathws);
            
            $this->conectado = true;
        }
    }

    public function soma($n1,$n2)
    {
    	$this->comunica();


    	 return $this->soap->somar($n1,$n2);
    }

}