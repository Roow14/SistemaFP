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
$id_avaliacao = $_GET['id_avaliacao'];
$id_paciente = $_SESSION['id_paciente'];

// apagar
$sql = "DELETE FROM avaliacao WHERE id_avaliacao = '$id_avaliacao'";
if ($conn->query($sql) === TRUE) {
} else {
}

// voltar
header("Location: index.php?id_paciente=$id_paciente");
exit;
?>
