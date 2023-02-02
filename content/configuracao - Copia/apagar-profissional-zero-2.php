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
$sql = "SELECT * FROM agenda_paciente_base WHERE id_profissional = 0";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$id_agenda_paciente_base = $row['id_agenda_paciente_base'];
		// apagar
		$sqlA = "DELETE FROM agenda_paciente_base WHERE id_agenda_paciente_base = '$id_agenda_paciente_base'";
		if ($conn->query($sqlA) === TRUE) {
		} else {
		}
    }

} else {
	// não tem
}


// voltar
header("Location: apagar-profissional-zero.php");
exit;
?>
