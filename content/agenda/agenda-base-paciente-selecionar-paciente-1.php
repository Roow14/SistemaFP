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
$id_paciente = $_GET['id_paciente'];
$id_categoria = $_POST['id_categoriaPesq'];
$id_unidade = $_POST['id_unidadePesq'];
$_SESSION['id_paciente'] = $id_paciente;
$_SESSION['id_categoria'] = $id_categoria;
$_SESSION['id_unidade'] = $id_unidade;

// voltar
header("Location: agenda-base-paciente.php?id_paciente=$id_paciente&id_categoria=$id_categoria&id_unidade=$id_unidade");
exit;
?>
