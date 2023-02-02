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
$id_doutor = $_POST['id_doutor'];
$id_diagnostico = $_POST['id_diagnostico'];

if (empty($_POST['DataPedidoMedico'])) {
	// atualizar
	$sql = "UPDATE pedido_medico SET DataPedidoMedico = NULL WHERE id_pedido_medico = '$id_pedido_medico' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
} else {
	// atualizar
	$sql = "UPDATE pedido_medico SET DataPedidoMedico = '$DataPedidoMedico' WHERE id_pedido_medico = '$id_pedido_medico' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

if (empty($_POST['id_doutor'])) {
	// atualizar
	$sql = "UPDATE pedido_medico SET id_doutor = NULL WHERE id_pedido_medico = '$id_pedido_medico' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
} else {
	// atualizar
	$sql = "UPDATE pedido_medico SET id_doutor = '$id_doutor' WHERE id_pedido_medico = '$id_pedido_medico' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

if (empty($_POST['id_diagnostico'])) {
} else {
	// atualizar
	$sql = "UPDATE pedido_medico SET id_diagnostico = '$id_diagnostico' WHERE id_pedido_medico = '$id_pedido_medico' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

// voltar
header("Location: cadastrar-pedido-medico-3.php?id_paciente=$id_paciente&id_pedido_medico=$id_pedido_medico");
exit;
?>
