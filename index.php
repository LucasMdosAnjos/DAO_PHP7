<?php

require_once("config.php");

//Carrega um usuário

//$root = new Usuario();
//$root->loadById(3);
//------------------------------
//Carrega uma lista de usuarios
//$lista = Usuario::getList();
//echo json_encode($lista);
//------------------------------
//Carrega uma pesquisa por login
//$search = Usuario::search2("dale");
//echo json_encode($search);
//-----------------------------
//Carrega um usuário usando o login e a senha
$usuario = new Usuario();
$usuario->login("mec","meczada");
echo $usuario;

?>