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
$id_exame = $_GET['id_exame'];
$id_paciente = $_SESSION['id_paciente'];

// apagar
$sql = "DELETE FROM exame_novo WHERE id_exame = '$id_exame'";
if ($conn->query($sql) === TRUE) {
} else {
}

// voltar
header("Location: index.php?id_paciente=$id_paciente");
exit;
?>
