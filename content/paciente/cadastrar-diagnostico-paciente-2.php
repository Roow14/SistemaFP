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
$DataDiagnostico = $_POST['DataDiagnostico'];
$NotaDiagnostico = $_POST['NotaDiagnostico'];
$id_diagnostico = $_POST['id_diagnostico'];

// verificar se tem diagnóstico cadastrado
// buscar xxx
$sqlA = "SELECT * FROM diagnostico_paciente WHERE id_paciente = '$id_paciente' AND id_diagnostico = '$id_diagnostico'";
$resultA = $conn->query($sqlA);
if ($resultA->num_rows > 0) {
    while($rowA = $resultA->fetch_assoc()) {
		// tem, não salvar
		echo 'Erro: o diagnóstico está cadastrado no sistema.<br>';
		echo '<a href="cadastrar-diagnostico-paciente.php?id_paciente='.$id_paciente.'">Voltar</a>';
		exit;
    }
} else {
	// não tem, salvar
	// inserir
	$sql = "INSERT INTO diagnostico_paciente (id_paciente, id_diagnostico, DataDiagnostico) VALUES ('$id_paciente', '$id_diagnostico', '$DataDiagnostico')";
	if ($conn->query($sql) === TRUE) {
	} else {
	}

	// buscar recém criado
	$sql = "SELECT * FROM diagnostico_paciente ORDER BY Timestamp DESC LIMIT 1";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			$id_diagnostico_paciente = $row['id_diagnostico_paciente'];
	    }
	} else {
	}

	if (empty($_POST['NotaDiagnostico'])) {

	} else {
		// atualizar
		$sql = "UPDATE diagnostico_paciente SET NotaDiagnostico = '$NotaDiagnostico' WHERE id_diagnostico_paciente = '$id_diagnostico_paciente' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}
	}
}

// voltar
header("Location: diagnostico-paciente.php?id_paciente=$id_paciente");
exit;
?>
