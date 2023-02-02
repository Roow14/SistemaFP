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
$id_midia_avaliacao = $_GET['id_midia_avaliacao'];
$ArquivoMidia = $_GET['ArquivoMidia'];
$id_avaliacao = $_GET['id_avaliacao'];

$Arquivo = '../../vault/avaliacao/'.$id_paciente.'/'.$ArquivoMidia;
unlink($Arquivo);

// apagar
$sql = "DELETE FROM midia_avaliacao WHERE id_midia_avaliacao = '$id_midia_avaliacao'";
if ($conn->query($sql) === TRUE) {
} else {
}

// voltar
header("Location: alterar-avaliacao.php?id_avaliacao=$id_avaliacao");
exit;
