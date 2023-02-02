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
$id_midia_ajuda = $_GET['id_midia_ajuda'];
$ArquivoMidia = $_GET['ArquivoMidia'];

// apagar
$sql = "DELETE FROM fisiofor_agenda.midia_ajuda WHERE id_midia_ajuda = '$id_midia_ajuda'";
if ($conn->query($sql) === TRUE) {
} else {
}

unlink('../../vault/ajuda/'.$ArquivoMidia);

// voltar
header("Location: ajuda.php");
exit;
