<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 1;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';

if (isset($_SESSION['ApagarArquivoAjuda'])) {
    unset($_SESSION['ApagarArquivoAjuda']);
} else {
    $_SESSION['ApagarArquivoAjuda'] = 'sim';
}

// fechar e voltar
header("Location: ajuda.php");
exit;
?>