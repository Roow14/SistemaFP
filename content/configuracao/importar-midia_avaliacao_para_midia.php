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
$sql = "SELECT * FROM midia_avaliacao ORDER BY ArquivoMidia ASC";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$id_midia_avaliacao = $row['id_midia_avaliacao'];
		$ArquivoMidia = $row['ArquivoMidia'];
		$id_paciente = $row['id_paciente'];

		// buscar xxx
		$sqlA = "SELECT * FROM midia WHERE ArquivoMidia = '$ArquivoMidia'";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				// tem
				echo $ArquivoMidia.' (já existe)<br>';
		    }
		} else {
			// não tem
			$Vault = 1;
			// inserir
			$sqlA = "INSERT INTO midia (id_paciente, ArquivoMidia, Vault) VALUES ('$id_paciente', '$ArquivoMidia', '$Vault')";
			if ($conn->query($sqlA) === TRUE) {
			} else {
			}
		}
    }
} else {
	// não tem
}

// voltar
header("Location: configurar-arquivos-importados.php"); exit;
?>
