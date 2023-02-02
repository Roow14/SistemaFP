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
$DataSessao = $_POST['DataSessao'];

// buscar dados
$sql = "SELECT * FROM pedido_medico WHERE id_pedido_medico = '$id_pedido_medico'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$id_diagnostico_paciente = $row['id_diagnostico_paciente'];
		$Doutor = $row['Doutor'];
		$Crm = $row['Crm'];
		$DataPedidoMedico = $row['DataPedidoMedico'];
		$DataPedidoMedico1 = date("d/m/Y", strtotime($DataPedidoMedico));
		$NotaPedidoMedico = $row['NotaPedidoMedico'];
		$id_categoria = $row['id_categoria'];
		$NumeroSessoes = $row['NumeroSessoes'];
		$TotalHoras = $row['TotalHoras'];
		$NotaPedidoMedico = $row['NotaPedidoMedico'];
		$StatusPedidoMedico = $row['StatusPedidoMedico'];
		// buscar xxx
		$sqlA = "SELECT * FROM diagnostico_paciente WHERE id_diagnostico_paciente = '$id_diagnostico_paciente'";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				$id_diagnostico = $rowA['id_diagnostico'];
		    }
		} else {
		}
    }
} else {
}

// inserir
$sql = "INSERT INTO sessao (id_paciente, id_diagnostico, id_categoria, DataSessao, id_pedido_medico) VALUES ('$id_paciente', '$id_diagnostico', '$id_categoria', '$DataSessao', '$id_pedido_medico')";
if ($conn->query($sql) === TRUE) {
	echo 'ok;';
} else {
	echo 'erro';
}

// buscar xxx
$sql = "SELECT * FROM sessao ORDER BY Timestamp DESC LIMIT 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$id_sessao = $row['id_sessao'];
    }
} else {
}

// voltar
header("Location: cadastrar-sessao.php?id_paciente=$id_paciente&id_pedido_medico=$id_pedido_medico");
exit;
?>
