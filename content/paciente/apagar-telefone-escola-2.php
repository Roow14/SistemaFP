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
$id_escola = $_GET['id_escola'];
$id_telefone_escola = $_GET['id_telefone_escola'];

// apagar
$sql = "DELETE FROM telefone_escola WHERE id_telefone_escola = '$id_telefone_escola'";
if ($conn->query($sql) === TRUE) {
} else {
}

// voltar
header("Location: cadastrar-telefone-email-escola.php?id_escola=$id_escola");
exit;
