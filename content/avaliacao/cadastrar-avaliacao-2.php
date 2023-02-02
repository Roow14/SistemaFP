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
$id_paciente = $_SESSION['id_paciente'];
date_default_timezone_set("America/Sao_Paulo");
$DataAtualX = date("d/m/Y");
$DataAtual = date("Y-m-d");

// inserir
$sql = "INSERT INTO avaliacao (id_paciente, DataAvaliacao) VALUES ('$id_paciente', '$DataAtual')";
if ($conn->query($sql) === TRUE) {
} else {
}

// buscar xxx
$sql = "SELECT * FROM avaliacao ORDER BY id_avaliacao DESC LIMIT 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$id_avaliacao = $row['id_avaliacao'];
    }
} else {
	// não tem
}

// voltar
header("Location: alterar-avaliacao.php?id_avaliacao=$id_avaliacao");
exit;
?>