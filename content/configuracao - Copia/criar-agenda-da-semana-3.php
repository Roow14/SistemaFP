<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 2;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// input


if ($DiaSemana == 2) {
	// segunda
	$Data = $DayWeek;
} elseif ($DiaSemana == 3) {
	// terça
	$date = date_create($DayWeek);
	date_add($date,date_interval_create_from_date_string("1 day"));
	$Data = date_format($date,"Y-m-d");
} elseif ($DiaSemana == 4) {
	// quarta
	$date = date_create($DayWeek);
	date_add($date,date_interval_create_from_date_string("2 day"));
	$Data = date_format($date,"Y-m-d");
} elseif ($DiaSemana == 5) {
	// quinta
	$date = date_create($DayWeek);
	date_add($date,date_interval_create_from_date_string("3 day"));
	$Data = date_format($date,"Y-m-d");
} elseif ($DiaSemana == 6) {
	// sexta
	$date = date_create($DayWeek);
	date_add($date,date_interval_create_from_date_string("4 day"));
	$Data = date_format($date,"Y-m-d");
} else {
}

// buscar xxx
$sqlA = "SELECT * FROM agenda_paciente_base WHERE DiaSemana = '$DiaSemana'";
$resultA = $conn->query($sqlA);
if ($resultA->num_rows > 0) {
    while($rowA = $resultA->fetch_assoc()) {
		// tem
		$id_paciente = $rowA['id_paciente'];
		$id_profissional = $rowA['id_profissional'];
		$id_unidade = $rowA['id_unidade'];
		$id_categoria = $rowA['id_categoria'];
		$id_hora = $rowA['id_hora'];
		$id_periodo = $rowA['id_periodo'];
			
		// inserir
		$sqlB = "INSERT INTO agenda_paciente (id_paciente, id_profissional, id_unidade, id_categoria, id_hora, id_periodo, Data, DiaSemana) VALUES ('$id_paciente', '$id_profissional', '$id_unidade', '$id_categoria', '$id_hora', '$id_periodo', '$Data', '$DiaSemana')";
		if ($conn->query($sqlB) === TRUE) {
		} else {
		}
    }
} else {
	// não tem
}	
?>
