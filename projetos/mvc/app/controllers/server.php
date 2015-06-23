<?php

class Server extends Controller
{
	public function __construct()
	{

		$this->model('calculadora');


	}

	public function ws()
	{

		//NO WSDL IRA EXECUTAR O SERVER
		$servidor = new SoapServer('http://localhost/projetos/mvc/app/webservice.wsdl');
  		// definimos a classe responsável por executar os métodos descritos no WSDL
  		$servidor->setClass("Calculadora");
  		// e finalmente gerenciamos a requisição
  		$servidor->handle();

		
	}

}