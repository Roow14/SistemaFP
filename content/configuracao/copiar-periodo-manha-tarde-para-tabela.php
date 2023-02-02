<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 2;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';

// verificar se o periodo existe na tabela
$sql = "SELECT * FROM categoria_profissional_tmp WHERE id_periodo10 = 10";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$id_profissional = $row['id_profissional'];
		$id_categoria = $row['id_categoria'];
		$id_unidade = $row['id_unidade'];

		// buscar xxx
		$sqlA = "SELECT * FROM categoria_profissional WHERE id_profissional = '$id_profissional' AND id_categoria = '$id_categoria' AND id_unidade = '$id_unidade' AND id_periodo = 10";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				// tem
				// $aa = $rowA['aa'];
		    }
		} else {
			// não tem
			// inserir
			$sqlB = "INSERT INTO categoria_profissional (id_profissional, id_categoria, id_unidade, id_periodo) VALUES ('$id_profissional', '$id_categoria', '$id_unidade', 10)";
			if ($conn->query($sqlB) === TRUE) {
			} else {
			}
		}
    }
} else {
	// não tem
}	

// voltar
// header("Location: configurar-estado.php?id=#$id_estado");
exit;
?>
