<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 2;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';

// input
$DataAgenda = $_POST['DataAgenda'];
$id_hora = $_POST['id_hora'];
$id_categoria = $_POST['id_categoriaX'];
$id_unidade = $_POST['id_unidadeX'];

$_SESSION['DataAgenda'] = $DataAgenda;
$_SESSION['id_hora'] = $id_hora;
$_SESSION['id_categoria'] = $id_categoria;
$_SESSION['id_unidade'] = $id_unidade;

// voltar
header("Location: agenda-paciente.php");
exit;
?>
