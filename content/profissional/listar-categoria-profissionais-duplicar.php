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
$id_categoria_profissional = $_GET['id_categoria_profissional'];

// buscar xxx
$sql = "SELECT * FROM categoria_profissional WHERE id_categoria_profissional = '$id_categoria_profissional'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// tem
		$id_profissional = $row['id_profissional'];
		$id_categoria = $row['id_categoria'];
    }
} else {
	// não tem
}

// inserir
$sql = "INSERT INTO categoria_profissional (id_profissional, id_categoria) VALUES ('$id_profissional', '$id_categoria')";
if ($conn->query($sql) === TRUE) {
} else {
}

// voltar
header("Location: listar-categoria-profissionais.php");
exit;
?>
