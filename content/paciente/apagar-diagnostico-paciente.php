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
$id_diagnostico_paciente = $_GET['id_diagnostico_paciente'];

// apagar
$sql = "DELETE FROM diagnostico_paciente WHERE id_diagnostico_paciente = '$id_diagnostico_paciente'";
if ($conn->query($sql) === TRUE) {
} else {
}

// voltar
header("Location: paciente.php?id_paciente=$id_paciente");
exit;
?>
