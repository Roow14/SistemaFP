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
$id_paciente = $_GET['id_paciente'];
$DiaSemana = $_GET['DiaSemana'];
$id_unidade = $_GET['id_unidade'];
$id_periodo = $_GET['id_periodo'];
$id_hora = $_GET['id_hora'];
$id_categoria = $_GET['id_categoria'];
$id_profissionalPesq = $_POST['id_profissionalPesq'];

if (empty($id_profissionalPesq)) {
	// mensagem de alerta
	echo "<script type=\"text/javascript\">
	    alert(\"Erro: o profissional tem uma agenda para este horário..\");
	    window.location = \"agenda-base-paciente.php\"
	    </script>";
	exit;
} else {
	// verificar se encontra cadastrado
	$sql = "SELECT * FROM agenda_paciente_base WHERE id_paciente = '$id_paciente' AND id_unidade = '$id_unidade' AND DiaSemana = '$DiaSemana' AND id_hora = '$id_hora'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
			// tem
			$id_agenda_paciente_base = $row['id_agenda_paciente_base'];
			$id_profissional = $row['id_profissional'];
	    }
	} else {
		// não tem, inserir novo
		$sqlA = "INSERT INTO agenda_paciente_base (id_paciente, id_unidade, DiaSemana, id_hora, id_periodo, id_categoria, id_profissional) VALUES ('$id_paciente', '$id_unidade', '$DiaSemana', '$id_hora', '$id_periodo', '$id_categoria', '$id_profissionalPesq')";
		if ($conn->query($sqlA) === TRUE) {
		} else {
		}
	}
}

// voltar
header("Location: agenda-base-paciente.php?id_paciente=$id_paciente&id_periodo=$id_periodo&id_unidade=$id_unidade&id_categoria=$id_categoria");
exit;
?>
