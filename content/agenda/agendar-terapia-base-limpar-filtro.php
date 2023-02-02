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
unset($_SESSION['id_categoria']);
unset($_SESSION['id_unidade']);
unset($_SESSION['DiaSemana']);
unset($_SESSION['id_hora']);

// voltar
header("Location: agendar-terapia-base.php");
exit;
?>
