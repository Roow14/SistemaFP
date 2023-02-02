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
$sqlA = "SELECT * FROM tmp_profissional";
$resultA = $conn->query($sqlA);
if ($resultA->num_rows > 0) {
    while($rowA = $resultA->fetch_assoc()) {
		$id_tmp_profissional = $rowA['id_tmp_profissional'];
		$NomeCompleto = $rowA['NomeCompleto'];
		$NomeCurto = $rowA['NomeCurto'];
		$id_funcao = $rowA['id_funcao'];

		// inserir
		$sql = "INSERT INTO profissional (NomeCompleto) VALUES ('$NomeCompleto')";
		if ($conn->query($sql) === TRUE) {
		} else {
		}

		// buscar xxx
		$sql = "SELECT * FROM profissional WHERE NomeCompleto = '$NomeCompleto'";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
		    while($row = $result->fetch_assoc()) {
				$id_profissional = $row['id_profissional'];
		    }
		} else {
		}

		// atualizar
		$sql = "UPDATE profissional SET NomeCurto = '$NomeCurto' WHERE id_profissional = '$id_profissional' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}

		// atualizar
		$sql = "UPDATE profissional SET id_funcao = '$id_funcao' WHERE id_profissional = '$id_profissional' ";
		if ($conn->query($sql) === TRUE) {
		} else {
		}
    }
} else {
}

// limpar dados da tabela
$sql = "TRUNCATE tmp_profissional";
if ($conn->query($sql) === TRUE) {
} else {
}

// voltar
header("Location: ../profissional/listar-profissionais.php");
exit;
?>
