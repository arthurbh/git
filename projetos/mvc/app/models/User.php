<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//use Illuminate\Database\Eloquent\Model as Eloquent; ORM
use Illuminate\Database\Capsule\Manager as Capsule;
class User extends Capsule
{
    public $name;
    
    protected $timestamp =[];
    protected $fillable = ['username','id'];
    

}