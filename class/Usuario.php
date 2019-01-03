<?php

class Usuario 
{
	private $idusuario;
	private $deslogin;
	private $dessenha;
	private $dtcadastro;

	public function setIdUsuario($id)
	{
		$this->idusuario = $id;
	}
	public function getIdUsuario()
	{
		return $this->idusuario;
	}
	public function setDesLogin($login)
	{
		$this->deslogin = $login;
	}
	public function getDesLogin()
	{
		return $this->deslogin;
	}
	public function setDesSenha($senha)
	{
		$this->dessenha = $senha;
	}
	public function getDesSenha()
	{
		return $this->dessenha;
	}
	public function setDtCadastro($dtcadastro)
	{
		$this->dtcadastro = $dtcadastro;
	}
	public function getDtCadastro()
	{
		return $this->dtcadastro;
	}
	public function loadById($id)
	{
		$sql = new Sql();
		$result = $sql->select("SELECT * FROM tb_usuarios WHERE idusuario = :ID", 
			array(":ID"=>$id));
		if(count($result)> 0 )
		{
			$this->setData($result[0]);
		}
	}
	public static function getList()
	{
		$sql = new Sql();
		return $sql->select("SELECT * FROM tb_usuarios ORDER BY deslogin");
	}
	public static function search($login) //Primeira maneira
	{
		$sql = new Sql();
		return $sql->select("SELECT * FROM tb_usuarios WHERE deslogin = :LOGIN",array(":LOGIN"=>$login));
	}
	public static function search2($login) //Segunda maneira
	{
		$sql = new Sql();
		return $sql->select("SELECT * FROM tb_usuarios WHERE deslogin LIKE :SEARCH ORDER BY deslogin",array(":SEARCH"=>"%". $login ."%"));
	}
	public function login($login,$password)
	{
		$sql = new Sql();
		$result = $sql->select("SELECT * FROM tb_usuarios WHERE deslogin = :LOGIN AND dessenha = :PASSWORD",
			array(":LOGIN"=>$login,":PASSWORD"=>$password));
		if(count($result)> 0 )
		{
		
			$this->setData($result[0]);
		} else
		{
			throw new Exception("Login e/ou senha inválidos.");
			
		}
	}

	public function setData($data)
	{
			$this->setIdUsuario($data['idusuario']);
			$this->setDesLogin($data['deslogin']);
			$this->setDesSenha($data['dessenha']);
			$this->setDtCadastro(new DateTime($data['dtcadastro']));
	}

	public function insert()//Primeira maneira
	{
		$sql = new Sql();
		$results = $sql->select("INSERT INTO tb_usuarios(deslogin,dessenha) VALUES(:LOGIN, :PASSWORD)", array(
			':LOGIN'=>$this->getDesLogin()
			,':PASSWORD'=>$this->getDesSenha()
		));
		$results2 = $sql->select("SELECT * FROM tb_usuarios WHERE idusuario = LAST_INSERT_ID()");
		if(count($results2) > 0)
		{
			$this->setData($results2[0]);
		}
	}

	public function insert2()
	{
		$sql = new Sql();

		$results = $sql->select("CALL sp_usuarios_insert(:LOGIN,:PASSWORD)",array(
			":LOGIN"=>$this->getDesLogin(),":PASSWORD"=>$this->getDesSenha()));
		if(count($results)>0)
		{
			$this->setData($results[0]);
		}
	}
	public function update($login,$password)
	{
		$this->setDesLogin($login);
		$this->setDesSenha($password);
		$sql = new Sql();
		$sql->query("UPDATE tb_usuarios SET deslogin = :LOGIN, dessenha = :PASSWORD WHERE idusuario = :ID",array(":LOGIN"=>$this->getDesLogin(),":PASSWORD"=>$this->getDesSenha(),":ID"=>$this->getIdUsuario()));
	}
	public function __toString()
	{
		return json_encode(array(
			"idusuario"=>$this->getIdUsuario()
			,"deslogin"=>$this->getDesLogin()
			,"dessenha"=>$this->getDesSenha()
			,"dtcadastro"=>$this->getDtCadastro()->format("d/m/y H:i:s")
		));

	}
}
?>