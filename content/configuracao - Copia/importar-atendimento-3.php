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
$sqlA = "SELECT * FROM agenda_paciente_tmp";
$resultA = $conn->query($sqlA);
if ($resultA->num_rows > 0) {
    while($rowA = $resultA->fetch_assoc()) {
		$id_agenda_paciente_tmp = $rowA['id_agenda_paciente_tmp'];
		$id_paciente = $rowA['id_paciente'];
		$id_hora = $rowA['id_hora'];
		$DiaSemana = $rowA['DiaSemana'];
		$id_categoria = $rowA['id_categoria'];
		$id_profissional = $rowA['id_profissional'];
		$id_unidade = 1;
		$id_periodo = $rowA['id_periodo'];

		// inserir
		$sql = "INSERT INTO agenda_paciente (id_paciente, id_hora, DiaSemana, id_profissional, id_categoria, id_unidade, id_periodo) VALUES ('$id_paciente', '$id_hora', '$DiaSemana', '$id_profissional', '$id_categoria', '$id_unidade', '$id_periodo')";
		if ($conn->query($sql) === TRUE) {
		} else {
		}
    }
} else {
}

// limpar dados da tabela
$sql = "TRUNCATE agenda_paciente_tmp";
if ($conn->query($sql) === TRUE) {
} else {
}

// voltar
header("Location: ../agenda/cadastrar-atendimento.php");
exit;
?>
