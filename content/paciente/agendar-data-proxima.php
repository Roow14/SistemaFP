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
$id_pedido_medico = $_GET['id_pedido_medico'];
$id_categoria = $_GET['id_categoria'];
$DataSessao = $_GET['DataSessao'];
echo $DataSessao.'<br>';
// calcular próxima data
$DataProxima = date("Y-m-d", strtotime($DataSessao.'+1 day'));
$_SESSION['DataSessao'] = $DataProxima;

// voltar
header("Location: agendar-sessao.php?id_paciente=$id_paciente&id_pedido_medico=$id_pedido_medico&id_categoria=$id_categoria");
exit;
?>
