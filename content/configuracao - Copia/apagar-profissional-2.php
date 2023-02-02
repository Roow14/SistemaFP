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
$id_profissional = $_GET['id_profissional'];

// apagar
$sql = "DELETE FROM profissional_observacao WHERE id_profissional = '$id_profissional'";
if ($conn->query($sql) === TRUE) {
} else {
}

// apagar
$sql = "DELETE FROM endereco_profissional WHERE id_profissional = '$id_profissional'";
if ($conn->query($sql) === TRUE) {
} else {
}

// apagar
$sql = "DELETE FROM telefone_profissional WHERE id_profissional = '$id_profissional'";
if ($conn->query($sql) === TRUE) {
} else {
}

// apagar
$sql = "DELETE FROM email_profissional WHERE id_profissional = '$id_profissional'";
if ($conn->query($sql) === TRUE) {
} else {
}

// apagar
$sql = "DELETE FROM profissional WHERE id_profissional = '$id_profissional'";
if ($conn->query($sql) === TRUE) {
} else {
}

// voltar
header("Location: listar-terapeutas-duplicados.php");
exit;
?>
