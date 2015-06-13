<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../app/libs/Router.php';

$router = new Router();

$router::Rota(array('/home/index/sa' 	=> '/home/index/sa'));
$router::Rota(array('/home/testes' 		=> '/Teste/testes'));


require_once '../app/init.php';


$app 	= new App($router);
