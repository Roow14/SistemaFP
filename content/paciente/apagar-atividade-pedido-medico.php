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
$id_pedido_medico_atividade = $_GET['id_pedido_medico_atividade'];
$id_pedido_medico = $_GET['id_pedido_medico'];

// apagar
$sql = "DELETE FROM pedido_medico_atividade WHERE id_pedido_medico_atividade = '$id_pedido_medico_atividade'";
if ($conn->query($sql) === TRUE) {
} else {
}

// voltar
header("Location: cadastrar-pedido-medico-3.php?id_paciente=$id_paciente&id_pedido_medico=$id_pedido_medico");
exit;
