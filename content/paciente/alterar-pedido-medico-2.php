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
$DataPedidoMedico = $_POST['DataPedidoMedico'];
$id_medico = $_POST['id_medico'];
$Observacao = $_POST['Observacao'];

if (empty($_POST['id_medico'])) {
} else {
	// atualizar
	$sql = "UPDATE pedido_medico SET id_medico = '$id_medico' WHERE id_pedido_medico = '$id_pedido_medico' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

if (empty($_POST['DataPedidoMedico'])) {
} else {
	// atualizar
	$sql = "UPDATE pedido_medico SET DataPedidoMedico = '$DataPedidoMedico' WHERE id_pedido_medico = '$id_pedido_medico' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

if (empty($_POST['Observacao'])) {
} else {
	// atualizar
	$sql = "UPDATE pedido_medico SET Observacao = '$Observacao' WHERE id_pedido_medico = '$id_pedido_medico' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}
	
// unset($_SESSION['AtivarAlteracaoPedidoMedico']);

// voltar
header("Location: pedido-medico.php?id_paciente=$id_paciente&id_pedido_medico=$id_pedido_medico");
exit;
?>
