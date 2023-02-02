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
$id_terapia = $_GET['id_terapia'];
$Origem = $_GET['Origem'];

// verificar se o terapia foi utilizada em algum paciente
$sql = "SELECT * FROM terapia_paciente WHERE id_terapia = '$id_terapia'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		echo 'erro: a terapia está sendo utilizada.';
		$_SESSION['ErroApagarDiagnostico'] = 'erro';
    }
} else {
	// não tem
	echo 'não tem';
	// apagar
	$sqlA = "DELETE FROM terapia WHERE id_terapia = '$id_terapia'";
	if ($conn->query($sqlA) === TRUE) {
		echo 'terapia apagada';
	} else {
		echo 'a terapiao não foi apagada.';
	}
}

// voltar
if (empty($_GET['Origem'])) {
	header("Location: configurar-terapia.php");
} else {
	$Origem = $_GET['Origem'];
	header("Location: configurar-terapia.php?Origem=$Origem");
}
exit;
?>
