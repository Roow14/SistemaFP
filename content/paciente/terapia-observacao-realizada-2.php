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
$ObsTerapiaRealizada = $_POST['ObsTerapiaRealizada'];

// buscar xxx
$sql = "SELECT * FROM terapia_observacao WHERE id_paciente = '$id_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
    	$id_terapia_observacao = $row['id_terapia_observacao'];

    	if (empty($_POST['ObsTerapiaRealizada'])) {
    		// atualizar
			$sqlA = "UPDATE terapia_observacao SET ObsTerapiaRealizada = NULL WHERE id_terapia_observacao = '$id_terapia_observacao' ";
			if ($conn->query($sqlA) === TRUE) {
			} else {
			}
    	} else {
    		// atualizar
			$sqlA = "UPDATE terapia_observacao SET ObsTerapiaRealizada = '$ObsTerapiaRealizada' WHERE id_terapia_observacao = '$id_terapia_observacao' ";
			if ($conn->query($sqlA) === TRUE) {
			} else {
			}
    	}
    }
} else {
	// inserir
	$sqlA = "INSERT INTO terapia_observacao (ObsTerapiaRealizada, id_paciente) VALUES ('$ObsTerapiaRealizada', '$id_paciente')";
	if ($conn->query($sqlA) === TRUE) {
	} else {
	}
}

// voltar
header("Location: listar-terapias-realizadas.php?id_paciente=$id_paciente");
exit;
?>
