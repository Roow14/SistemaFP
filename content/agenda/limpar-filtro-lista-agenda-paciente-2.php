<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 1;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';

unset($_SESSION['DataInicial']);
unset($_SESSION['DataFinal']);
unset($_SESSION['id_categoria']);
unset($_SESSION['id_convenio']);

// voltar
header("Location: lista-agenda-paciente.php");
exit;
?>
