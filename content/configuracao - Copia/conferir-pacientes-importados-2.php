<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 2;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';

// buscar xxx
$sqlA = "SELECT * FROM tmp_paciente_1";
$resultA = $conn->query($sqlA);
if ($resultA->num_rows > 0) {
    while($rowA = $resultA->fetch_assoc()) {
		$NomeCompleto = $rowA['NomeCompleto'];
		$NomeCurto = $rowA['NomeCurto'];
		$Pai = $rowA['Pai'];
		$Mae = $rowA['Mae'];
		$DataNascimento = $rowA['DataNascimento'];

		// inserir
		$sql = "INSERT INTO paciente (NomeCompleto) VALUES ('$NomeCompleto')";
		if ($conn->query($sql) === TRUE) {
		} else {
		}

		// buscar xxx
		$sql = "SELECT * FROM paciente ORDER BY id_paciente DESC LIMIT 1";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
		    while($row = $result->fetch_assoc()) {
				$id_paciente = $row['id_paciente'];
		    }
		} else {
		}

		// atualizar
		$sql = "UPDATE paciente SET NomeCurto = '$NomeCurto' WHERE id_paciente = '$id_paciente' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}

		// atualizar
		$sql = "UPDATE paciente SET Pai = '$Pai' WHERE id_paciente = '$id_paciente' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}

		// atualizar
		$sql = "UPDATE paciente SET Mae = '$Mae' WHERE id_paciente = '$id_paciente' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}

		// atualizar
		$sql = "UPDATE paciente SET DataNascimento = '$DataNascimento' WHERE id_paciente = '$id_paciente' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}
    }
} else {
}	

// voltar
header("Location: ../paciente/listar-pacientes.php");
exit;
?>
