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
$id_paciente = $_POST['id_pacientePesq'];
$id_categoria = $_POST['id_categoriaPesq'];

// voltar
header("Location: cadastrar-atendimento.php?id_paciente=$id_paciente&id_categoria=$id_categoria");
exit;
?>
