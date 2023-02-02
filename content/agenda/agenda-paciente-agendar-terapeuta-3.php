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
$id_profissional = $_POST['id_profissionalX'];
$id_paciente = $_SESSION['id_paciente'];
$Data = $_SESSION['DataAgenda'];
$id_unidade = $_SESSION['id_unidade'];
$id_hora = $_SESSION['id_hora'];
$id_categoria = $_SESSION['id_categoria'];

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
	    window.location = \"agenda-paciente.php\"
	    </script>";
	exit;
}

// verificar se encontra cadastrado
$sql = "SELECT * FROM agenda_paciente WHERE id_paciente = '$id_paciente' AND id_unidade = '$id_unidade' AND Data = '$Data' AND id_hora = '$id_hora'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		// mensagem de alerta
		echo "<script type=\"text/javascript\">
		    alert(\"Erro: Tem um terapeuta agendado.\");
		    window.location = \"agenda-paciente.php\"
		    </script>";
		exit;
    }
} else {
	// não tem, inserir novo
	$sqlA = "INSERT INTO agenda_paciente (id_paciente, id_unidade, Data, DiaSemana, id_hora, id_periodo, id_categoria, id_profissional) VALUES ('$id_paciente', '$id_unidade', '$Data', '$DiaSemana', '$id_hora', '$id_periodo', '$id_categoria', '$id_profissional')";
	if ($conn->query($sqlA) === TRUE) {
	} else {
	}
}

// voltar
header("Location: agenda-paciente.php");
exit;
?>
