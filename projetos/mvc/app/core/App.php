<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To chan ge this template file, choose Tools | Templates
 * and open the template in the editor.
 */



class App extends Router {


    protected $controller   = 'home';
    
    protected $method       = 'index';
    
    protected $params       = [];

    private  $pathurl       = null;
    
    public function __construct(Router $router) {
        
        /* RETORNAR A URL COMO UM EXPLODE*/

        if(isset($_SERVER['PATH_INFO']))
        {
            $rotapredefinida    = $_SERVER['PATH_INFO'];
             $this->pathurl     =  $_SERVER['PATH_INFO'];

            if($rotas      = $router::findRota($rotapredefinida))
            {
                if($rotas != null)
                    $this->pathurl = $rotas;
            } 
        }
       

        $url            = $this->parseUrl();

        
        if(file_exists('../app/controllers/'.$url[0].'.php'))
        { 
            require_once '../app/controllers/'.$this->controller.'.php';
            $this->controller = $url[0];
            unset($url[0]);
        
        if(class_exists($this->controller))
        {
            $this->controller = new $this->controller;
            
            if(isset($url[1]))
            {
                if(is_callable(array($this->controller,$url[1])))
                {
                    $this->method = $url[1];
                    unset($url[1]);
                }
                else
                    $this->error();
            }
            
        }
        else
            $this->error();
        
        }
        else 
            $this->error();
        
        $this->params = $url ? array_values($url) : [];
        
        $this->call();
  
    }
    
    private function error()
    {
        require_once '../app/controllers/error.php';
        $this->controller = new Error();
    }
    
    public function call()
    {
        call_user_func_array([$this->controller,$this->method],$this->params);
    }
    
    public function parseUrl()
    {
        
        if($this->pathurl != null)
        {
            // .htacess
            $this->pathurl  = (substr($this->pathurl, 0,1) == '/') ? substr($this->pathurl, 1,strlen($this->pathurl)) : $this->pathurl;
            $url            = explode('/',filter_var(rtrim($this->pathurl,'/'),FILTER_SANITIZE_URL));
            
            return $url;
            
        }
        else
        {
            $url = array('error','index');
            return $url;
        }
            
        /*
         * .htacess 
        if(isset($_GET['url']))
        { 
            return $url = explode('/',filter_var(rtrim($_GET['url'],'/'),FILTER_SANITIZE_URL));
        }
         * */
         
    }
    
}
