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
$id_funcao = $_GET['id_funcao'];

// apagar
$sql = "DELETE FROM funcao WHERE id_funcao = '$id_funcao'";
if ($conn->query($sql) === TRUE) {
} else {
}

// voltar
header("Location: configurar-funcao.php");
exit;
?>
