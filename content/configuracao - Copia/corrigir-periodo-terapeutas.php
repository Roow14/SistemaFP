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
$sql = "SELECT * FROM categoria_profissional WHERE id_periodo = 10";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$id_categoria_profissional = $row['id_categoria_profissional'];
		$id_periodo = $row['id_periodo'];
		$id_profissional = $row['id_profissional'];
		$id_categoria = $row['id_categoria'];

		$sqlA = "SELECT * FROM profissional WHERE id_profissional = '$id_profissional'";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				// tem
				$NomeCompleto = $rowA['NomeCompleto'];
		    }
		} else {
			// não tem
		}

		// buscar xxx
		$sqlA = "SELECT * FROM agenda_paciente_base WHERE id_profissional = '$id_profissional'";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				// tem
				echo $id_profissional.' - '.$NomeCompleto.' - '.$id_categoria.' - '.$id_periodo.'<br>';
		    }
		} else {
			// não tem
		}

		
    }
} else {
	// não tem
}

// alterar id_periodo 12 para 2 e 16 para 1
$sql = "SELECT * FROM agenda_paciente_base";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$id_agenda_paciente_base = $row['id_agenda_paciente_base'];
		$id_periodo = $row['id_periodo'];
		$id_profissional = $row['id_profissional'];
		// echo $id_periodo.' - '.$id_profissional.'<br>';

		if ($id_periodo == 12) {
			// atualizar
			$sqlA = "UPDATE agenda_paciente_base SET id_periodo = 2 WHERE id_agenda_paciente_base = '$id_agenda_paciente_base' ";
			if ($conn->query($sqlA) === TRUE) {
			} else {
			}
		}
		if ($id_periodo == 16) {
			// atualizar
			$sqlA = "UPDATE agenda_paciente_base SET id_periodo = 1 WHERE id_agenda_paciente_base = '$id_agenda_paciente_base' ";
			if ($conn->query($sqlA) === TRUE) {
			} else {
			}
		}
    }
} else {
	// não tem
}	

// alterar id_periodo 12 para 2 e 16 para 1
$sql = "SELECT * FROM categoria_profissional ORDER BY Timestamp ASC";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$id_categoria_profissional = $row['id_categoria_profissional'];
		$id_periodo = $row['id_periodo'];
		$id_profissional = $row['id_profissional'];
		// echo $id_periodo.' - '.$id_profissional.'<br>';
		if ($id_periodo == 12) {
			// atualizar
			$sqlA = "UPDATE categoria_profissional SET id_periodo = 2 WHERE id_categoria_profissional = '$id_categoria_profissional' ";
			if ($conn->query($sqlA) === TRUE) {
			} else {
			}
		}
		if ($id_periodo == 16) {
			// atualizar
			$sqlA = "UPDATE categoria_profissional SET id_periodo = 1 WHERE id_categoria_profissional = '$id_categoria_profissional' ";
			if ($conn->query($sqlA) === TRUE) {
			} else {
			}
		}

    }
} else {
	// não tem
}

// apagar id_periodo 10 e 13
$sql = "SELECT * FROM categoria_profissional WHERE id_periodo = 10";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$id_categoria_profissional = $row['id_categoria_profissional'];
		// apagar
		$sqlA = "DELETE FROM categoria_profissional WHERE id_categoria_profissional = '$id_categoria_profissional'";
		if ($conn->query($sqlA) === TRUE) {
		} else {
		}
    }
} else {
	// não tem
}

// apagar id_periodo 10 e 13
$sql = "SELECT * FROM categoria_profissional WHERE id_periodo = 11";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$id_categoria_profissional = $row['id_categoria_profissional'];
		// apagar
		$sqlA = "DELETE FROM categoria_profissional WHERE id_categoria_profissional = '$id_categoria_profissional'";
		if ($conn->query($sqlA) === TRUE) {
		} else {
		}
    }
} else {
	// não tem
}

$sql = "SELECT * FROM categoria_profissional WHERE id_periodo = 13";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$id_categoria_profissional = $row['id_categoria_profissional'];
		// apagar
		$sqlA = "DELETE FROM categoria_profissional WHERE id_categoria_profissional = '$id_categoria_profissional'";
		if ($conn->query($sqlA) === TRUE) {
		} else {
		}
    }
} else {
	// não tem
}

$sql = "SELECT * FROM categoria_profissional WHERE id_periodo = 3";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$id_categoria_profissional = $row['id_categoria_profissional'];
		// apagar
		$sqlA = "DELETE FROM categoria_profissional WHERE id_categoria_profissional = '$id_categoria_profissional'";
		if ($conn->query($sqlA) === TRUE) {
		} else {
		}
    }
} else {
	// não tem
}
?>