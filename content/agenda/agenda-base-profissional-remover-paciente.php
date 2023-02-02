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
$id_agenda_paciente_base = $_GET['id_agenda_paciente_base'];

// apagar
$sql = "DELETE FROM agenda_paciente_base WHERE id_agenda_paciente_base = '$id_agenda_paciente_base'";
if ($conn->query($sql) === TRUE) {
} else {
}

// voltar
header("Location: agenda-base-profissional.php");
exit;
?>
