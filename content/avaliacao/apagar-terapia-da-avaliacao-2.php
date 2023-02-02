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
$id_avaliacao = $_GET['id_avaliacao'];
$id_categoria_paciente = $_GET['id_categoria_paciente'];
$id_paciente = $_SESSION['id_paciente'];

// apagar
$sql = "DELETE FROM categoria_paciente WHERE id_categoria_paciente = '$id_categoria_paciente'";
if ($conn->query($sql) === TRUE) {
} else {
}

// voltar
header("Location: alterar-avaliacao.php?id_avaliacao=$id_avaliacao");
exit;
?>
