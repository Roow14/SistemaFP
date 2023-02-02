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
$id_exame = $_GET['id_exame'];
$id_pedido_medico = $_GET['id_pedido_medico'];

// buscar xxx
$sql = "SELECT * FROM exame_paciente WHERE id_exame = '$id_exame' AND id_pedido_medico = '$id_pedido_medico'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$id_exame_paciente = $row['id_exame_paciente'];
		// apagar
		$sql = "DELETE FROM exame_paciente WHERE id_exame_paciente = '$id_exame_paciente'";
		if ($conn->query($sql) === TRUE) {
		} else {
		}
    }
} else {
	// não tem
	// inserir
	$sql = "INSERT INTO exame_paciente (id_exame, id_pedido_medico) VALUES ('$id_exame', '$id_pedido_medico')";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}


// voltar
header("Location: pedido-medico.php?id_paciente=$id_paciente&id_pedido_medico=$id_pedido_medico");
exit;
?>
