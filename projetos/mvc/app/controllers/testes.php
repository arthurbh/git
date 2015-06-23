<?php

class Testes extends Controller
{

	protected $user;

	private $table 	= 'user';

	public function __construct()
	{
		#$this->user = $this->model('User');
	}


	public function index($names = null,$name2 = null)
	{
			
			$result['name'] 		= $names;
			$result['name2']		= $name2;
			$this->view('home/index',$result);
			#$this->view('home/index',['name' => $this->user->name]);
	}

	public function consulta()
	{
		try
		{
			$consulta = User::table($this->table)->where('id','>',0)->get();
			if($consulta)
			{
				$result['consulta'] = $consulta;
			}
			else
				$result['consulta'] = null;
			
		}
		catch(Exception $e)
		{
			echo $e->getmessage();
			$result['consulta'] = null;

		}

		$this->view('home/index', $result);
		
	}

	public function create($usuario)
	{
		try
		{
			$insert = User::insert('insert into '.$this->table.' (nome) values (?)', [$usuario]);

			if($insert){
					$result['message'] = 'Cadastrado com sucesso!';
			}
			else
				$result['message'] = 'Erro ao cadastrar!';
			
		}
		catch(Exception $e)
		{
			# $e->getmessage();
			$result['message'] = 'Erro ao cadastrar!';
		}
		
			$this->view('home/cadastro', $result);
		
	}
	
}