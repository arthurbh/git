<?php

class App
{

	protected $controller   = 'home';

	protected $method 		= 'index';

	protected $params 		= [];

	public function __construct()
	{
		$url = $this->parseUrl();

		if(file_exists(PATH.'controllers/'.$url[0].'.php'))
		{

			$this->controller = $url[0];

			include PATH.'controllers/'.$this->controller.'.php';
 		
			
			unset($url[0]);

			
		
 		if(class_exists($this->controller))
		{

			$this->controller = new $this->controller;
		
			
			if(isset($url[1]))
			{

				$method = $url[1];

				if(is_callable(array($this->controller, $method)))
				{
					$this->method = $method;

					unset($url[1]);

					$this->params = $url ? array_values($url) : [];

					$this->call();
				}
				else
					$this->error();
					
			}
			else
				$this->call();

		}
		else
			$this->error();

	}
	else
		$this->error();
	}

	public function error()
	{
		require_once PATH.'controllers/error.php';
		$this->controller = new error();
		$this->call();
	}

	public function call()
	{
		call_user_func_array([$this->controller,$this->method], $this->params);
	}

	public function parseUrl()
	{

		if(isset($_SERVER['PATH_INFO']))
		{
			#HTACCESS RewriteRule (.*) index.php/$1
			$_SERVER['PATH_INFO'] = (substr($_SERVER['PATH_INFO'],0,1) == '/')  ? substr($_SERVER['PATH_INFO'],1,strlen($_SERVER['PATH_INFO'])) : $_SERVER['PATH_INFO'];
			return $url = explode('/',filter_var(rtrim($_SERVER['PATH_INFO'],'/'), FILTER_SANITIZE_URL));
		
		}
		else
		{
			$url = array('error','index');
			return $url;
		}

		/*

		if(isset($_GET['url']))
		{
			.htaccess #RewriteRule ^(.+)$ index.php?url=$1 [QSA,L]
			return $url = explode('/',filter_var(rtrim($_GET['url'],'/'), FILTER_SANITIZE_URL));
			
		}

		*/
	}
}