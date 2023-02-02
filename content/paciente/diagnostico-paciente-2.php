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
$id_diagnostico = $_POST['id_diagnostico'];
$NomeDiagnostico = $_POST['NomeDiagnostico'];
$DataDiagnostico = $_POST['DataDiagnostico'];

// inserir
$sql = "INSERT INTO diagnostico_paciente (id_paciente, id_diagnostico, DataDiagnostico) VALUES ('$id_paciente', '$id_diagnostico', '$DataDiagnostico')";
if ($conn->query($sql) === TRUE) {
	echo $sql;
	echo '<br>';
} else {
	echo 'Erro: '.$sql;
	echo '<br>';
}

// buscar id recém criado
$sql = "SELECT * FROM diagnostico_paciente ORDER BY Timestamp DESC LIMIT 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
    	$id_diagnostico_paciente = $row['id_diagnostico_paciente'];
    }
} else {
}

// atualizar nota se houver
if (empty($_POST['NotaDiagnostico'])) {
} else {
	$NotaDiagnostico = $_POST['NotaDiagnostico'];
	$sql = "UPDATE diagnostico_paciente SET NotaDiagnostico = '$NotaDiagnostico' WHERE id_diagnostico_paciente = '$id_diagnostico_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

// voltar
header("Location: diagnostico-paciente.php?id_paciente=$id_paciente");
exit;
?>
