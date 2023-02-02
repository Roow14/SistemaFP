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
$sql = "SELECT * FROM categoria_profissional ORDER BY id_profissional ASC";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$id_categoria_profissional = $row['id_categoria_profissional'];
		$id_profissional = $row['id_profissional'];
		$id_categoria = $row['id_categoria'];
		$id_unidade = $row['id_unidade'];
		$id_periodo = $row['id_periodo'];

		if ($id_categoria == 10) {
			// buscar xxx
			$sqlA = "SELECT * FROM categoria_profissional WHERE id_profissional = '$id_profissional' AND id_periodo = 1";
			$resultA = $conn->query($sqlA);
			if ($resultA->num_rows > 0) {
			    while($rowA = $resultA->fetch_assoc()) {
					// tem
			    }
			} else {
				// não tem
				// inserir
				$sqlB = "INSERT INTO categoria_profissional (id_profissional, id_categoria, id_unidade, id_periodo) VALUES ('$id_profissional', '$id_categoria', '$id_unidade', 1)";
				if ($conn->query($sqlB) === TRUE) {
					echo $id_profissional.' - '.$id_categoria.' - '.$id_unidade.' - '.$id_periodo.'<br>';
				} else {
				}
			}

			// buscar xxx
			$sqlA = "SELECT * FROM categoria_profissional WHERE id_profissional = '$id_profissional' AND id_periodo = 2";
			$resultA = $conn->query($sqlA);
			if ($resultA->num_rows > 0) {
			    while($rowA = $resultA->fetch_assoc()) {
					// tem
			    }
			} else {
				// não tem
				// inserir
				$sqlB = "INSERT INTO categoria_profissional (id_profissional, id_categoria, id_unidade, id_periodo) VALUES ('$id_profissional', '$id_categoria', '$id_unidade', 2)";
				if ($conn->query($sqlB) === TRUE) {
					echo $id_profissional.' - '.$id_categoria.' - '.$id_unidade.' - '.$id_periodo.'<br>';
				} else {
				}
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
