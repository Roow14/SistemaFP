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
$id_convenio = $_GET['id_convenio'];

// apagar
$sql = "DELETE FROM convenio WHERE id_convenio = '$id_convenio'";
if ($conn->query($sql) === TRUE) {
} else {
}

// voltar
header("Location: listar-convenio.php");
exit;
?>
