<?php




class Controller
{
 // models e views

	protected $websoap = null;

	public function __construct()
	{
		  $this->ws_soap       = WebService::getInstance();
	}

	protected function model($model)
	{
		
			//r
			if(class_exists($model))
			return new $model();

			else
			{
				require  PATH.'models/'.$model.'.php';
				return new $model();
			}
	}

	public function view($view,$data = [])
	{

		require_once PATH.'views/'.$view.'.php';

	}
}