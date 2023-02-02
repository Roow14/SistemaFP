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
$id_diagnostico = $_GET['id_diagnostico'];

if (empty($_GET['Origem'])) {
} else {
	$Origem = $_GET['Origem'];
}

if (empty($_GET['id_paciente'])) {
} else {
	$id_paciente = $_GET['id_paciente'];
}

// verificar se o diagnósitico foi utilizado em algum paciente
$sql = "SELECT * FROM diagnostico_paciente WHERE id_diagnostico = '$id_diagnostico'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		echo 'erro: o diagnóstico está sendo utilizado.';
		$_SESSION['ErroApagarDiagnostico'] = 'erro';
    }
} else {
	// não tem
	echo 'não tem';
	// apagar
	$sqlA = "DELETE FROM diagnostico WHERE id_diagnostico = '$id_diagnostico'";
	if ($conn->query($sqlA) === TRUE) {
		echo 'diagnóstico apagado';
	} else {
		echo 'o diagnóstico não foi apagado.';
	}
}

// voltar
if (empty($_GET['Origem'])) {
	header("Location: configurar-diagnostico.php");
} else {
	$Origem = $_GET['Origem'];
	header("Location: configurar-diagnostico.php?Origem=$Origem&id_paciente=$id_paciente");
}
exit;
?>
