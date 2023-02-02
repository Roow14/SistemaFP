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

// apagar
$sql = "DELETE FROM escola WHERE id_escola = '$id_escola'";
if ($conn->query($sql) === TRUE) {
} else {
}

// apagar
$sql = "DELETE FROM endereco_escola WHERE id_escola = '$id_escola'";
if ($conn->query($sql) === TRUE) {
} else {
}

// apagar
$sql = "DELETE FROM email_escola WHERE id_escola = '$id_escola'";
if ($conn->query($sql) === TRUE) {
} else {
}

// apagar
$sql = "DELETE FROM telefone_escola WHERE id_escola = '$id_escola'";
if ($conn->query($sql) === TRUE) {
} else {
}

unset($_SESSION['AtivarRemocaoEscola']);

// voltar
header("Location: listar-escolas.php");
exit;
