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
$NomeTitulo = $_POST['NomeTitulo'];

// inserir
$sql = "INSERT INTO prog_atividade_titulo (NomeTitulo) VALUES ('$NomeTitulo')";
if ($conn->query($sql) === TRUE) {
} else {
}

// buscar récém criado
$sql = "SELECT * FROM prog_atividade_titulo ORDER BY id_atividade_titulo DESC LIMIT 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$id_atividade_titulo = $row['id_atividade_titulo'];
    }
} else {
	// não tem
}

// voltar
header("Location: cadastrar-atividade-1.php?id_atividade_titulo=$id_atividade_titulo");
exit;
?>
 