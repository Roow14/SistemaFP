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
$id_agenda_paciente = $_POST['id_agenda_paciente'];
$id_profissional = $_POST['id_profissionalX'];
$id_paciente = $_SESSION['id_paciente'];
$Data = $_SESSION['DataAgenda'];
$id_unidade = $_POST['id_unidade'];
$id_hora = $_POST['id_hora'];
$id_categoria = $_POST['id_categoria'];

// buscar xxx
$sql = "SELECT * FROM hora WHERE id_hora = '$id_hora'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$Periodo = $row['Periodo'];
		// buscar xxx
		$sqlA = "SELECT * FROM periodo WHERE Periodo = '$Periodo'";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				// tem
				$id_periodo = $rowA['id_periodo'];
		    }
		} else {
			// não tem
		}
    }
} else {
	// não tem
}

$DayWeek = (strftime("%a", strtotime($Data)));
// verificar se é segunda
if ($DayWeek == 'Mon') {
	$DiaSemana = 2;
} elseif ($DayWeek == 'Tue' ) {
	$DiaSemana = 3;
} elseif ($DayWeek == 'Wed' ) {
	$DiaSemana = 4;
} elseif ($DayWeek == 'Thu' ) {
	$DiaSemana = 5;
} elseif ($DayWeek == 'Fri' ) {
	$DiaSemana = 6;
} else {
	// mensagem de alerta
	echo "<script type=\"text/javascript\">
	    alert(\"Erro: Escolha uma data de segunda a sexta.\");
	    window.location = \"relatorio-agenda-paciente-box.php?id_agenda_paciente=$id_agenda_paciente\"
	    </script>";
	exit;
}

// atualizar
$sql = "UPDATE agenda_paciente SET id_profissional = '$id_profissional' WHERE id_agenda_paciente = '$id_agenda_paciente' ";
if ($conn->query($sql) === TRUE) {
} else {
}

// voltar
header("Location: relatorio-agenda-paciente-box.php?id_agenda_paciente=$id_agenda_paciente");
exit;
?>
