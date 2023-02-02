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
$id_convenio = $_GET['id_convenio'];
$NomeConvenio = $_POST['NomeConvenio'];
$Nota = $_POST['Nota'];
$StatusConvenio = $_POST['StatusConvenio'];

// atualizar
$sql = "UPDATE convenio SET NomeConvenio = '$NomeConvenio' WHERE id_convenio = '$id_convenio' ";
if ($conn->query($sql) === TRUE) {
} else {
}

$sql = "UPDATE convenio SET Nota = '$Nota' WHERE id_convenio = '$id_convenio' ";
if ($conn->query($sql) === TRUE) {
} else {
}

$sql = "UPDATE convenio SET StatusConvenio = '$StatusConvenio' WHERE id_convenio = '$id_convenio' ";
if ($conn->query($sql) === TRUE) {
} else {
}
// voltar
header("Location: convenio.php?id_convenio=$id_convenio");
exit;
?>
