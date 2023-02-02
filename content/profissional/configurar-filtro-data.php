<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 1;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';
 
// input
$id_profissional = $_GET['id_profissional'];
$DataDe = $_POST['DataDe'];
$DataPara = $_POST['DataPara'];

$_SESSION['DataDe'] = $DataDe;

if ($DataPara < $DataDe) {
	$_SESSION['DataPara'] = $DataDe;
} else {
	$_SESSION['DataPara'] = $DataPara;
}

// voltar
header("Location: agenda-profissional.php?id_profissional=$id_profissional");
exit;
?>
