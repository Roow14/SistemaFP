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
$NomeDiagnostico = $_POST['NomeDiagnostico'];
$Cid = $_POST['Cid'];

if (empty($_GET['Origem'])) {
} else {
	$Origem = $_GET['Origem'];
}

if (empty($_GET['id_paciente'])) {
} else {
	$id_paciente = $_GET['id_paciente'];
}

// buscar diagnóstico
$sql = "SELECT * FROM diagnostico WHERE NomeDiagnostico = '$NomeDiagnostico'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		echo 'Erro: O nome se encontra cadastrado no sistema.<br>';
		echo '<a href="configurar-diagnostico.php">Voltar</a>';
		echo '<br>';
		$_SESSION['ErroAdicionarDiagnostico'] = 'erro';
		if (empty($_GET['Origem'])) {
			header("Location: configurar-diagnostico.php");
		} else {
			header("Location: configurar-diagnostico.php?Origem=$Origem&id_paciente=$id_paciente");
		}
		exit;
    }
} else {
}
echo $sql;
echo '<br>';

if (empty($_POST['NomeDiagnostico'])) {

} else {
	if (empty($_POST['Cid'])) {
		// inserir
		$sql = "INSERT INTO diagnostico (NomeDiagnostico) VALUES ('$NomeDiagnostico')";
		if ($conn->query($sql) === TRUE) {
			echo 'diagnóstico criado com sucesso.';
		} else {
			echo 'erro ao criar diagnóstico' .$sql;
		}
	} else {
		// inserir
		$sql = "INSERT INTO diagnostico (NomeDiagnostico, Cid) VALUES ('$NomeDiagnostico', '$Cid')";
		if ($conn->query($sql) === TRUE) {
			echo 'diagnóstico com cid criado com sucesso.';
		} else {
			echo 'erro ao criar diagnóstico com cid' .$sql;
		}
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
