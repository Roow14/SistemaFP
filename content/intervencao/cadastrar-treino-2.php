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
$id_paciente = $_POST['id_paciente'];
$id_objetivo = $_POST['id_objetivo'];
$prog_procedimento_tmp = 'prog_procedimento_tmp_'.$_SESSION['UsuarioID'];
$prog_reforcador_tmp = 'prog_reforcador_tmp'.$_SESSION['UsuarioID'];
$id_profissional = $_POST['id_profissional'];

// inserir
$sql = "INSERT INTO prog_objetivo_paciente (id_objetivo, id_paciente) VALUES ('$id_objetivo', '$id_paciente')";
if ($conn->query($sql) === TRUE) {
} else {
}

// buscar xxx
$sql = "SELECT * FROM prog_objetivo_paciente ORDER BY id_objetivo_paciente DESC LIMIT 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$id_objetivo_paciente = $row['id_objetivo_paciente'];
    }
} else {
}

// input múltiplo para procedimento
foreach ($_POST['id_procedimento'] as $Item => $Valor) {
	echo $Item.' > '.$Valor.'<br>';

	// inserir
	$sql = "INSERT INTO prog_procedimento_paciente (id_procedimento, id_objetivo_paciente, id_paciente) VALUES ('$Valor', '$id_objetivo_paciente', '$id_paciente')";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

// input múltiplo para reforçador
foreach ($_POST['id_reforcador'] as $Item => $Valor) {
	echo $Item.' > '.$Valor.'<br>';

	// inserir
	$sql = "INSERT INTO prog_reforcador_paciente (id_reforcador, id_objetivo_paciente, id_paciente) VALUES ('$Valor', '$id_objetivo_paciente', '$id_paciente')";
	if ($conn->query($sql) === TRUE) {
		echo $sql.'<br>';
	} else {
		echo 'erro'.$sql.'<br>';
	}
}

// inserir
$sql = "INSERT INTO prog_treino_paciente (id_objetivo_paciente, id_paciente) VALUES ('$id_objetivo_paciente', '$id_paciente')";
if ($conn->query($sql) === TRUE) {
	echo $sql.'<br>';
} else {
	echo 'erro'.$sql.'<br>';
}

// buscar xxx
$sql = "SELECT * FROM prog_treino_paciente ORDER BY id_treino_paciente DESC LIMIT 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$id_treino_paciente = $row['id_treino_paciente'];
		echo $sql.'<br>';
    }
} else {
	echo 'erro'.$sql.'<br>';
}

if (empty($_POST['id_profissional'])) {

} else {
	// atualizar
	$sql = "UPDATE prog_treino_paciente SET id_profissional = '$id_profissional' WHERE id_treino_paciente = '$id_treino_paciente' ";
	if ($conn->query($sql) === TRUE) {
	} else {
	}
}

// voltar
header("Location: treino.php?id_treino_paciente=$id_treino_paciente&id_paciente=$id_paciente");
exit;
?>
 