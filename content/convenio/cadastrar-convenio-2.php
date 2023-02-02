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
$NomeConvenio = $_POST['NomeConvenio'];
$Nota = $_POST['Nota'];

// verificar se o nome está cadastrado
$sql = "SELECT * FROM convenio WHERE NomeConvenio = '$NomeConvenio'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		
    }
} else {
	// não tem
	if (empty($Nota)) {
		// inserir
		$sqlA = "INSERT INTO convenio (NomeConvenio) VALUES ('$NomeConvenio')";
		if ($conn->query($sqlA) === TRUE) {
		} else {
		}
	} else {
		// inserir
		$sqlA = "INSERT INTO convenio (NomeConvenio, Nota) VALUES ('$NomeConvenio', '$Nota')";
		if ($conn->query($sqlA) === TRUE) {
		} else {
		}
	}
}

// voltar
header("Location: listar-convenio.php");
exit;
?>
