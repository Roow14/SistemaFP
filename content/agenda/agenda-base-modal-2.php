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
$DiaSemana = $_POST['DiaSemana'];
$id_hora = $_POST['id_hora'];
$id_paciente = $_POST['id_paciente'];
$id_categoria = $_POST['id_categoria'];
$id_profissional = $_POST['id_profissional'];
$id_unidade = $_SESSION['id_unidade'];
$Auxiliar = $_SESSION['Auxiliar'];

if (empty($id_profissional)) {
	// mensagem de alerta
	echo "<script type=\"text/javascript\">
	    alert(\"Erro: selecione um terapeuta disponível neste horário.\");
	    window.location = \"agenda-base-paciente.php\"
	    </script>";
	exit;
}

// verificar se o profissional (terapeuta ou auxiliar) está agendado
$sql = "SELECT * FROM agenda_paciente_base WHERE DiaSemana = '$DiaSemana' AND id_hora = '$id_hora' AND id_paciente = '$id_paciente' AND id_categoria = '$id_categoria' AND id_profissional = '$id_profissional' AND id_unidade = '$id_unidade' ";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		// mensagem de alerta
		echo "<script type=\"text/javascript\">
		    alert(\"Erro: o terapeuta está agendado neste horário.\");
		    window.location = \"agenda-base-paciente.php\"
		    </script>";
		exit;
    }
} else {
	// não tem
}

// ver se é auxiliar ou não
// é auxiliar
if ($Auxiliar == 1) {
	// ver se tem terapeuta
	$sql = "SELECT * FROM agenda_paciente_base WHERE DiaSemana = '$DiaSemana' AND id_hora = '$id_hora' AND id_paciente = '$id_paciente' AND id_categoria = '$id_categoria' AND Auxiliar = 2 AND id_unidade = '$id_unidade' ";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			// tem
			// inserir
			$sqlA = "INSERT INTO agenda_paciente_base (DiaSemana, id_hora, id_paciente, id_categoria, id_profissional, id_unidade, Auxiliar) VALUES ('$DiaSemana', '$id_hora', '$id_paciente', '$id_categoria', '$id_profissional', '$id_unidade', 1)";
			if ($conn->query($sqlA) === TRUE) {
			} else {
			}
	    }
	} else {
		// não tem
		// mensagem de alerta
		echo "<script type=\"text/javascript\">
		    alert(\"Erro: agende um terapeuta antes de agendar um auxiliar.\");
		    window.location = \"agenda-base-paciente.php\"
		    </script>";
		exit;
	}
}

// não é auxiliar, é terapeuta
if ($Auxiliar == 2) {
	// inserir
	$sql = "INSERT INTO agenda_paciente_base (DiaSemana, id_hora, id_paciente, id_categoria, id_profissional, id_unidade, Auxiliar) VALUES ('$DiaSemana', '$id_hora', '$id_paciente', '$id_categoria', '$id_profissional', '$id_unidade', 2)";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

header("Location: agenda-base-paciente.php"); 
exit;
?>