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
$id_categoria = $_POST['id_categoria'];
$NumeroSessoes = $_POST['NumeroSessoes'];
$TotalHoras = $_POST['TotalHoras'];

if (empty($_POST['id_categoria'])) {

} else {
	// atualizar
	$sql = "UPDATE pedido_medico_atividade SET id_categoria = '$id_categoria' WHERE id_pedido_medico_atividade = '$id_pedido_medico_atividade' ";
	if ($conn->query($sql) === TRUE) {
		echo $sql;
	} else {
		echo 'erro'.$sql;
	}
}

if (empty($_POST['NumeroSessoes'])) {

} else {
	// atualizar
	$sql = "UPDATE pedido_medico_atividade SET NumeroSessoes = '$NumeroSessoes' WHERE id_pedido_medico_atividade = '$id_pedido_medico_atividade' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

if (empty($_POST['TotalHoras'])) {

} else {
	// atualizar
	$sql = "UPDATE pedido_medico_atividade SET TotalHoras = '$TotalHoras' WHERE id_pedido_medico_atividade = '$id_pedido_medico_atividade' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}
// voltar
header("Location: cadastrar-pedido-medico-3.php?id_paciente=$id_paciente&id_pedido_medico=$id_pedido_medico");
exit;
?>
