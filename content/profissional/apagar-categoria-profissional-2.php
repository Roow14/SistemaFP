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
$id_categoria_profissional = $_GET['id_categoria_profissional'];
$id_profissional = $_GET['id_profissional'];

// apagar
$sql = "DELETE FROM categoria_profissional WHERE id_categoria_profissional = '$id_categoria_profissional'";
if ($conn->query($sql) === TRUE) {
} else {
}

// voltar
header("Location: categoria-profissional.php?id_profissional=$id_profissional");
exit;
?>
