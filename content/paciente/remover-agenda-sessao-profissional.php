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
$id_sessao = $_GET['id_sessao'];
$id_sessao_paciente = $_GET['id_sessao_paciente'];

// buscar dados da sessão
$sql = "SELECT * FROM agenda_profissional WHERE id_sessao = '$id_sessao'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$id_agenda_profissional = $row['id_agenda_profissional'];
    }
} else {
}

// apagar
$sql = "DELETE FROM agenda_profissional WHERE id_agenda_profissional = '$id_agenda_profissional'";
if ($conn->query($sql) === TRUE) {
	echo $sql;
	echo '<br>';
} else {
	echo 'erro:'.$sql;
	echo '<br>';
}

// apagar
$sql = "DELETE FROM sessao WHERE id_sessao = '$id_sessao'";
if ($conn->query($sql) === TRUE) {
	echo $sql;
	echo '<br>';
} else {
	echo 'erro:'.$sql;
	echo '<br>';
}

// recalcular sessão
$sql = "SELECT COUNT(id_sessao) AS SomaSessaoAgendada FROM sessao WHERE id_sessao_paciente = '$id_sessao_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	// tem
	while($row = $result->fetch_assoc()) {
		$SomaSessaoAgendada = $row['SomaSessaoAgendada'];
		// atualizar
		$sqlA = "UPDATE sessao_paciente SET SessaoAgendada = '$SomaSessaoAgendada' WHERE id_sessao_paciente = '$id_sessao_paciente' ";
		if ($conn->query($sqlA) === TRUE) {
		} else {
		}
	}
// não tem
} else {
	// atualizar
	$sqlA = "UPDATE sessao_paciente SET SessaoAgendada = NULL WHERE id_sessao_paciente = '$id_sessao_paciente' ";
	if ($conn->query($sqlA) === TRUE) {
	} else {
	}
}

// voltar
header("Location: agendar-sessao.php?id_paciente=$id_paciente&id=#$id_profissional");
exit;
?>
