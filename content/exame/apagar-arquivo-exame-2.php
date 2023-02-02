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
$id_paciente = $_GET['id_paciente'];
$id_midia_exame = $_GET['id_midia_exame'];
$id_exame = $_GET['id_exame'];
$ArquivoMidia = $_GET['ArquivoMidia'];

$Arquivo = '../../vault/exame/'.$id_paciente.'/'.$ArquivoMidia;
unlink($Arquivo);

// apagar
$sql = "DELETE FROM midia_exame WHERE id_midia_exame = '$id_midia_exame'";
if ($conn->query($sql) === TRUE) {
} else {
}

// voltar
header("Location: alterar-exame.php?id_exame=$id_exame");
exit;
