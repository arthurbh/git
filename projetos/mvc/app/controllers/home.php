<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Home extends Controller
{
   
    protected $user;
    
    protected $table = 'users';
    
    public function __construct() {
        $this->user = $this->model('User');
    }


    public function index($name = '')
    {
       $this->view('home/index',['name' =>  $name]);
        
    }
    
    public function consulta()
    {
        $users = User::table('user')->where('id', '>', 0)->get();

     
        var_dump($users);
    }
    
    public function create($username)
    {
       /*
       User::create([
          'nome' => $username 
       ]);
        * */
        
        //User::insert('insert into user (id,nome) values (?)', [1,'Dayle']);
        
    //$results = User::select('select * from user where id = ?', array(1));
     
    
   // $users = User::table('user')->where('id', '>', 0)->get();

     $users = User::insert('insert into user (nome) values (?)', [$username]);
     var_dump($users);
    }
    
    public function teste()
    {
        echo 'teste';
    }
    
}
