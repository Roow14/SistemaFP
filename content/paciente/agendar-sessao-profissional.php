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
$id_profissional = $_GET['id_profissional'];
$id_paciente = $_GET['id_paciente'];
$DataSessao = $_GET['DataSessao'];
$id_hora = $_GET['id_hora'];
$id_periodo = $_GET['id_periodo'];
$id_categoria = $_SESSION['id_categoria'];
$id_unidade = $_SESSION['id_unidade'];
$id_sessao_paciente = $_SESSION['id_sessao_paciente'];

// buscar xxx
$sql = "SELECT * FROM hora WHERE id_hora = '$id_hora'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$Periodo = $row['Periodo'];
		// buscar xxx
		$sqlA = "SELECT * FROM periodo WHERE Periodo = '$Periodo'";
		$resultA = $conn->query($sqlA);
		if ($resultA->num_rows > 0) {
		    while($rowA = $resultA->fetch_assoc()) {
				$id_periodo = $rowA['id_periodo'];
		    }
		} else {
		}
    }
} else {
}

// verificar se a sessão com data e horário coincidem
// buscar xxx
$sql = "SELECT * FROM sessao WHERE id_paciente = '$id_paciente' AND DataSessao = '$DataSessao' AND id_hora = '$id_hora'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		echo 'Erro: a data e horário já está registrado no sistema.<br>';
		$_SESSION['ErroPacienteAgendado'] = 'sim';
		// voltar
		header("Location: agendar-sessao.php?id_paciente=$id_paciente&id=#$id_profissional");
		exit;
    }
} else {
}

// inserir
$sql = "INSERT INTO sessao (id_paciente, id_sessao_paciente, id_profissional, DataSessao, id_hora, id_periodo, id_categoria, id_unidade) VALUES ('$id_paciente', '$id_sessao_paciente', '$id_profissional', '$DataSessao', '$id_hora', '$id_periodo', '$id_categoria', '$id_unidade')";
if ($conn->query($sql) === TRUE) {
	echo $sql;
} else {
	echo 'erro: '.$sql;
}
echo '<br>';

// buscar xxx
$sql = "SELECT * FROM sessao ORDER BY id_sessao DESC LIMIT 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$id_sessao = $row['id_sessao'];
    }
} else {
}

// inserir
$sql = "INSERT INTO agenda_profissional (id_paciente, id_profissional, DataSessao, id_hora, id_categoria, id_unidade, id_sessao) VALUES ('$id_paciente', '$id_profissional', '$DataSessao', '$id_hora', '$id_categoria', '$id_unidade', '$id_sessao')";
if ($conn->query($sql) === TRUE) {
	echo $sql;
} else {
	echo 'erro: '.$sql;
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
