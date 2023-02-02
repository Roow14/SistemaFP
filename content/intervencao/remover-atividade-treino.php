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
$id_atividade_paciente = $_GET['id_atividade_paciente'];
$id_treino_paciente = $_GET['id_treino_paciente'];
$id_paciente = $_GET['id_paciente'];

// apagar
$sql = "DELETE FROM prog_atividade_paciente WHERE id_atividade_paciente = '$id_atividade_paciente'";
if ($conn->query($sql) === TRUE) {
} else {
}

// voltar
header("Location: treino.php?id_treino_paciente=$id_treino_paciente&id_paciente=$id_paciente");
exit;
?>
