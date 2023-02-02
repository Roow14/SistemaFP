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
$ObsTerapiaSolicitada = $_POST['ObsTerapiaSolicitada'];

// buscar xxx
$sql = "SELECT * FROM terapia_observacao WHERE id_paciente = '$id_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
    	$id_terapia_observacao = $row['id_terapia_observacao'];

    	if (empty($_POST['ObsTerapiaSolicitada'])) {
    		// atualizar
			$sqlA = "UPDATE terapia_observacao SET ObsTerapiaSolicitada = NULL WHERE id_terapia_observacao = '$id_terapia_observacao' ";
			if ($conn->query($sqlA) === TRUE) {
			} else {
			}
    	} else {
    		// atualizar
			$sqlA = "UPDATE terapia_observacao SET ObsTerapiaSolicitada = '$ObsTerapiaSolicitada' WHERE id_terapia_observacao = '$id_terapia_observacao' ";
			if ($conn->query($sqlA) === TRUE) {
			} else {
			}
    	}
    }
} else {
	// inserir
	$sqlA = "INSERT INTO terapia_observacao (ObsTerapiaSolicitada, id_paciente) VALUES ('$ObsTerapiaSolicitada', '$id_paciente')";
	if ($conn->query($sqlA) === TRUE) {
	} else {
	}
}

// voltar
header("Location: listar-terapias-solicitadas.php?id_paciente=$id_paciente");
exit;
?>
