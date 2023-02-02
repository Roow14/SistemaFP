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
$id_hora = $_GET['id_hora'];

// apagar
$sql = "DELETE FROM hora WHERE id_hora = '$id_hora'";
if ($conn->query($sql) === TRUE) {
} else {
}

// voltar
header("Location: configurar-horas.php");
exit;
?>
