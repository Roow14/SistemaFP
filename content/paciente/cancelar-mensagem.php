<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 2;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';

$Origem = $_GET['Origem'];
$id_paciente = $_GET['id_paciente'];
$id_pedido_medico = $_GET['id_pedido_medico'];

unset($_SESSION['ErroSelecaoMedico']);
unset($_SESSION['ErroPacienteAgendado']);
unset($_SESSION['AtivarRemocaoPedidoMedico']);

if (empty($_GET['id_pedido_medico'])) {
	// voltar
	header("Location: $Origem?id_paciente=$id_paciente");
} else {
	// voltar
	header("Location: $Origem?id_paciente=$id_paciente&id_pedido_medico=$id_pedido_medico");
}
exit;
	
?>
