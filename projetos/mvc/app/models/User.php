<?php

use Illuminate\Database\Capsule\Manager as Capsule;

class User extends Capsule
{
	public $name;

	protected $timestamps = [];
	protected $fillable 	= ['id','nome'];
}