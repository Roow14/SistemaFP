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
$id_unidade = $_GET['id_unidade'];

// apagar
$sql = "DELETE FROM unidade WHERE id_unidade = '$id_unidade'";
if ($conn->query($sql) === TRUE) {
} else {
}

// voltar
header("Location: configurar-unidade.php");
exit;
?>
