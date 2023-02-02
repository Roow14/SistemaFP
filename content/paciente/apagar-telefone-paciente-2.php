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
$id_telefone_paciente = $_GET['id_telefone_paciente'];

// apagar
$sql = "DELETE FROM telefone_paciente WHERE id_telefone_paciente = '$id_telefone_paciente'";
if ($conn->query($sql) === TRUE) {
} else {
}

// voltar
header("Location: cadastrar-alterar-telefone-email-paciente.php?id_paciente=$id_paciente");
exit;
