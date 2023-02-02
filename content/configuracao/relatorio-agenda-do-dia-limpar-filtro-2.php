<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 2;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';

unset($_SESSION['id_unidade']);
unset($_SESSION['NomePaciente']);
unset($_SESSION['PesquisaPaciente']);
unset($_SESSION['PesquisaTerapeuta']);

// voltar
header("Location: relatorio-agenda-do-dia.php");
exit;
?>