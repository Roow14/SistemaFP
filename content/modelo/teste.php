<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 2;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';

// data atual
date_default_timezone_set("America/Sao_Paulo");
$DataAtual = date("Y-m-d");
$Data = date("d-m-Y", strtotime($DataAtual));

// setlocale(LC_TIME,"pt");
// echo(strftime("%A", strtotime($Data)));
$prog_proced_tmp = 'prog_proced_tmp_'.$_SESSION['UsuarioID'];

function table_exists(&$conn, $table)
{
	$result = $conn->query("SHOW TABLES LIKE '{$table}'");
	if( $result->num_rows == 1 )
	{
	        return TRUE;
	}
	else
	{
	        return FALSE;
	}
	$result->free();
}

?>