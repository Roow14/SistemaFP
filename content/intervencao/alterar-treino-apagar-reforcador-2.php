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
$id_treino_paciente = $_GET['id_treino_paciente'];
$id_paciente = $_GET['id_paciente'];
$id_reforcador = $_GET['id_reforcador'];

// buscar xxx
$sql = "SELECT * FROM prog_treino_paciente WHERE id_treino_paciente = '$id_treino_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$id_objetivo_paciente = $row['id_objetivo_paciente'];
    }
} else {
}

// apagar
$sql = "DELETE FROM prog_reforcador_paciente WHERE id_objetivo_paciente = '$id_objetivo_paciente' AND id_reforcador = '$id_reforcador'";
if ($conn->query($sql) === TRUE) {
} else {
}

// voltar
header("Location: alterar-treino.php?id_treino_paciente=$id_treino_paciente&id_paciente=$id_paciente");
exit;
?>
