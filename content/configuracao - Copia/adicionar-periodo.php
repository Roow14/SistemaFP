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
$NomePeriodo = $_POST['NomePeriodo'];
$Periodo = $_POST['Periodo'];

// buscar período
$sql = "SELECT * FROM periodo WHERE NomePeriodo = '$NomePeriodo'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		echo 'Erro: O nome se encontra cadastrado no sistema.<br>';
		echo '<a href="configurar-periodo.php">Voltar</a>';
    }
} else {
}

// inserir
$sql = "INSERT INTO periodo (NomePeriodo, Periodo) VALUES ('$NomePeriodo', '$Periodo')";
if ($conn->query($sql) === TRUE) {
} else {
}

// voltar
header("Location: configurar-periodo.php");
exit;
?>
