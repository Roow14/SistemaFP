<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 2;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}

// conexão com banco
include '../conexao/conexao.php';

date_default_timezone_set("America/Sao_Paulo");

// input
$id_paciente = $_GET['id_paciente'];
$DiaSemana = $_GET['DiaSemana'];
$id_hora = $_GET['id_hora'];
$id_profissional = $_POST['id_profissionalPesq'];
$id_categoria = 14;
$id_unidade = 1;

if (empty($id_profissional)) {
	// mensagem de alerta
	echo "<script type=\"text/javascript\">
	    alert(\"Erro: o terapeuta está agendado neste horário. Selecione um outro terapeuta.\");
	    window.location = \"agenda-equo-base-paciente.php\"
	    </script>";
	exit;
}

// buscar xxx
$sql = "SELECT * FROM hora WHERE id_hora = '$id_hora'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$id_periodo = $row['Periodo'];
    }
} else {
	// não tem
}

// verificar se o profissional já está cadastrado neste horário
// buscar xxx
$sql = "SELECT * FROM agenda_paciente_base WHERE id_profissional = '$id_profissional' AND DiaSemana = '$DiaSemana' AND id_hora = '$id_hora'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		// mensagem de alerta
		echo "<script type=\"text/javascript\">
		    alert(\"Erro: o terapeuta já está cadastrado neste horário.\");
		    window.location = \"agenda-equo-base-paciente.php\"
		    </script>";
		exit;
    }
} else {
	// não tem
}

// inserir
$sql = "INSERT INTO agenda_paciente_base (id_paciente, id_profissional, id_hora, id_categoria, id_unidade, id_periodo, DiaSemana, Auxiliar) VALUES ('$id_paciente', '$id_profissional', '$id_hora', '$id_categoria', '$id_unidade', '$id_periodo', '$DiaSemana', 1)";
if ($conn->query($sql) === TRUE) {
} else {
}

// voltar
header("Location: agenda-equo-base-paciente.php");
exit;
?>
