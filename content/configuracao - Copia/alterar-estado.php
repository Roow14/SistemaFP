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
$id_estado = $_GET['id_estado'];
$NomeEstado = $_POST['NomeEstado'];
$Estado = $_POST['Estado'];

// atualizar
$sql = "UPDATE estado SET NomeEstado = '$NomeEstado', Estado = '$Estado' WHERE id_estado = '$id_estado' ";
if ($conn->query($sql) === TRUE) {
} else {
}

// voltar
header("Location: configurar-estado.php?id=#$id_estado");
exit;
?>
