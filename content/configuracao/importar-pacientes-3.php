<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 2;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';

// limpar dados da tabela
$sql = "TRUNCATE tmp_paciente_1";
if ($conn->query($sql) === TRUE) {
} else {
}

// buscar xxx
$sqlA = "SELECT * FROM tmp_paciente";
$resultA = $conn->query($sqlA);
if ($resultA->num_rows > 0) {
    while($rowA = $resultA->fetch_assoc()) {
		$id_tmp_paciente = $rowA['id_tmp_paciente'];
		$NomeCompleto = $rowA['NomeCompleto'];
		list($NomeCurto, $Sobrenome) = explode(' ', $NomeCompleto);
		$Pai = $rowA['Pai'];
		$Mae = $rowA['Mae'];
		$DataNascimento = $rowA['DataNascimento'];

		// inserir
		$sql = "INSERT INTO tmp_paciente_1 (NomeCompleto) VALUES ('$NomeCompleto')";
		if ($conn->query($sql) === TRUE) {
		} else {
		}

		// buscar xxx
		$sql = "SELECT * FROM tmp_paciente_1 ORDER BY id_tmp_paciente_1 DESC LIMIT 1";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
		    while($row = $result->fetch_assoc()) {
				$id_tmp_paciente_1 = $row['id_tmp_paciente_1'];
		    }
		} else {
		}

		// atualizar
		$sql = "UPDATE tmp_paciente_1 SET NomeCurto = '$NomeCurto' WHERE id_tmp_paciente_1 = '$id_tmp_paciente_1' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}

		// atualizar
		$sql = "UPDATE tmp_paciente_1 SET Pai = '$Pai' WHERE id_tmp_paciente_1 = '$id_tmp_paciente_1' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}

		// atualizar
		$sql = "UPDATE tmp_paciente_1 SET Mae = '$Mae' WHERE id_tmp_paciente_1 = '$id_tmp_paciente_1' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}

		// atualizar
		$sql = "UPDATE tmp_paciente_1 SET DataNascimento = '$DataNascimento' WHERE id_tmp_paciente_1 = '$id_tmp_paciente_1' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}
    }
} else {
}	

// voltar
header("Location: conferir-pacientes-importados.php");
exit;
?>
