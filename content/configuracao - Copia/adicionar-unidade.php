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
$NomeUnidade = $_POST['NomeUnidade'];
$Unidade = $_POST['Unidade'];

// buscar unidade
$sql = "SELECT * FROM unidade WHERE NomeUnidade = '$NomeUnidade'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		echo 'Erro: O nome se encontra cadastrado no sistema.<br>';
		echo '<a href="configurar-unidade.php">Voltar</a>';
    }
} else {
}

// inserir
$sql = "INSERT INTO unidade (NomeUnidade, Unidade) VALUES ('$NomeUnidade', '$Unidade')";
if ($conn->query($sql) === TRUE) {
} else {
}

// voltar
header("Location: configurar-unidade.php");
exit;
?>
