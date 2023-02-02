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
$id_atividade_titulo = $_GET['id_atividade_titulo'];
$NomeTitulo = $_POST['NomeTitulo'];

// atualizar
$sql = "UPDATE prog_atividade_titulo SET NomeTitulo = '$NomeTitulo' WHERE id_atividade_titulo = '$id_atividade_titulo' ";
if ($conn->query($sql) === TRUE) {
} else {
}

echo $id_objetivo;
// voltar
header("Location: cadastrar-atividade-1.php?id_atividade_titulo=$id_atividade_titulo");
exit;
?>
