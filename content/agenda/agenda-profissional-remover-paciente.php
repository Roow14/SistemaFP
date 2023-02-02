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
$id_agenda_paciente = $_GET['id_agenda_paciente'];
$id_profissional = $_GET['id_profissional'];

// apagar
$sql = "DELETE FROM agenda_paciente WHERE id_agenda_paciente = '$id_agenda_paciente'";
if ($conn->query($sql) === TRUE) {
} else {
}

// voltar
header("Location: agenda-profissional.php?id_profissional=$id_profissional");
exit;
?>
