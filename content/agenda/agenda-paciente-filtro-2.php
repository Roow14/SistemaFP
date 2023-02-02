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
$id_unidade = $_POST['id_unidade'];
$id_categoria = $_POST['id_categoria'];
$Auxiliar = $_POST['Auxiliar'];
$Periodo = $_POST['Periodo'];

$_SESSION['id_unidade'] = $id_unidade;
$_SESSION['id_categoria'] = $id_categoria;
$_SESSION['Auxiliar'] = $Auxiliar;
$_SESSION['Periodo'] = $Periodo;

// voltar
header("Location: agenda-paciente.php");
exit;
?>
