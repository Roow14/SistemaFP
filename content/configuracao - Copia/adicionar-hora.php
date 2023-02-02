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
$Hora = $_POST['Hora'];

// calcular periodo
if ($Hora <= 12) {
	$Periodo = 1;
} else {
	$Periodo = 2;
}

// buscar xxx
$sql = "SELECT * FROM hora ORDER BY Ordem DESC LIMIT 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$Ordem = $row['Ordem'] + 1;
    }
} else {
	$Ordem = 1;
}

// inserir
$sql = "INSERT INTO hora (Ordem, Hora, Periodo) VALUES ('$Ordem', '$Hora', '$Periodo')";
if ($conn->query($sql) === TRUE) {
} else {
}

// voltar
header("Location: configurar-horas.php");
exit;
?>
