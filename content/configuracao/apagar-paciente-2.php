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

// buscar xxx
$sql = "SELECT * FROM endereco_paciente WHERE id_paciente = '$id_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$id_endereco_paciente = $row['id_endereco_paciente'];

		// apagar
		$sqlA = "DELETE FROM endereco_paciente WHERE id_endereco_paciente = '$id_endereco_paciente'";
		if ($conn->query($sqlA) === TRUE) {
		} else {
		}
    }
} else {
}

// buscar xxx
$sql = "SELECT * FROM paciente_observacao WHERE id_paciente = '$id_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$id_paciente_observacao = $row['id_paciente_observacao'];

		// apagar
		$sqlA = "DELETE FROM paciente_observacao WHERE id_paciente_observacao = '$id_paciente_observacao'";
		if ($conn->query($sqlA) === TRUE) {
		} else {
		}
    }
} else {
}

// apagar
$sql = "DELETE FROM telefone_paciente WHERE id_paciente = '$id_paciente'";
if ($conn->query($sql) === TRUE) {
} else {
}

// apagar
$sql = "DELETE FROM email_paciente WHERE id_paciente = '$id_paciente'";
if ($conn->query($sql) === TRUE) {
} else {
}

// apagar
$sql = "DELETE FROM paciente WHERE id_paciente = '$id_paciente'";
if ($conn->query($sql) === TRUE) {
} else {
}

// apagar
$sql = "DELETE FROM avaliacao WHERE id_paciente = '$id_paciente'";
if ($conn->query($sql) === TRUE) {
} else {
}

// apagar
$sql = "DELETE FROM convenio WHERE id_paciente = '$id_paciente'";
if ($conn->query($sql) === TRUE) {
} else {
}

// apagar
$sql = "DELETE FROM exame WHERE id_paciente = '$id_paciente'";
if ($conn->query($sql) === TRUE) {
} else {
}

// apagar
$sql = "DELETE FROM paciente_preferencia WHERE id_paciente = '$id_paciente'";
if ($conn->query($sql) === TRUE) {
} else {
}

// apagar
$sql = "DELETE FROM paciente_profissional WHERE id_paciente = '$id_paciente'";
if ($conn->query($sql) === TRUE) {
} else {
}

unset($_SESSION['AtivarRemocaoPaciente']);

// voltar
header("Location: listar-pacientes-duplicados.php");
exit;
