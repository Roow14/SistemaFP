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
$NomeFuncao = $_POST['NomeFuncao'];
// $Funcao = $_POST['Funcao'];

// buscar função
$sql = "SELECT * FROM funcao WHERE NomeFuncao = '$NomeFuncao'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		echo 'Erro: O nome se encontra cadastrado no sistema.<br>';
		echo '<a href="configurar-funcao.php">Voltar</a>';
    }
} else {
}

// inserir
$sql = "INSERT INTO funcao (NomeFuncao) VALUES ('$NomeFuncao')";
if ($conn->query($sql) === TRUE) {
} else {
}

// voltar
header("Location: configurar-funcao.php");
exit;
?>
