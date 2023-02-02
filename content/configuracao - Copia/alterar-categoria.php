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
$id_categoria = $_GET['id_categoria'];
$NomeCategoria = $_POST['NomeCategoria'];

// atualizar
$sql = "UPDATE categoria SET NomeCategoria = '$NomeCategoria' WHERE id_categoria = '$id_categoria' ";
if ($conn->query($sql) === TRUE) {
} else {
}

// voltar
header("Location: configurar-categoria.php");
exit;
?>
