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
$id_exame = $_GET['id_exame'];
$Origem = $_GET['Origem'];

// verificar se o exame foi utilizado em algum paciente
$sql = "SELECT * FROM exame_paciente WHERE id_exame = '$id_exame'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		echo 'erro: o exame está sendo utilizado.';
		$_SESSION['ErroApagarDiagnostico'] = 'erro';
    }
} else {
	// não tem
	echo 'não tem';
	// apagar
	$sqlA = "DELETE FROM exame WHERE id_exame = '$id_exame'";
	if ($conn->query($sqlA) === TRUE) {
		echo 'diagnóstico apagado';
	} else {
		echo 'o diagnóstico não foi apagado.';
	}
}

// voltar
if (empty($_GET['Origem'])) {
	header("Location: configurar-exame.php");
} else {
	$Origem = $_GET['Origem'];
	header("Location: configurar-exame.php?Origem=$Origem");
}
exit;
?>
