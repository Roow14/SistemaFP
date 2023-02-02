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
$DataPedidoMedico = $_POST['DataPedidoMedico'];
$id_medico = $_POST['id_medico'];
$Observacao = $_POST['Observacao'];

if (empty($_POST['id_medico'])) {
	$_SESSION['ErroSelecaoMedico'] = 'sim';
	// voltar
	header("Location: cadastrar-pedido-medico.php?id_paciente=$id_paciente");
	exit;

} else {
}

// inserir
$sql = "INSERT INTO pedido_medico (id_paciente, id_medico, DataPedidoMedico) VALUES ('$id_paciente', '$id_medico', '$DataPedidoMedico')";
if ($conn->query($sql) === TRUE) {
} else {
}

// buscar recém criado
$sql = "SELECT * FROM pedido_medico ORDER BY Timestamp DESC LIMIT 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$id_pedido_medico = $row['id_pedido_medico'];
    }
} else {
}

if (empty($_POST['Observacao'])) {
} else {
	// atualizar
	$sql = "UPDATE pedido_medico SET Observacao = '$Observacao' WHERE id_pedido_medico = '$id_pedido_medico' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

// input múlitplo
// exames
foreach ($_POST['Exame'] as $Item => $Valor) {
	echo $Item.''.$Valor.'<br>';
	// inserir
	$sql = "INSERT INTO exame_paciente (id_exame, id_pedido_medico) VALUES ('$Valor', '$id_pedido_medico')";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

// voltar
header("Location: pedido-medico.php?id_paciente=$id_paciente&id_pedido_medico=$id_pedido_medico");
exit;
?>
