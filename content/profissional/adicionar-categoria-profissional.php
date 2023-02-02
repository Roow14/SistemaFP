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
$id_profissional = $_GET['id_profissional'];
$id_categoria = $_POST['id_categoria'];
$id_periodo = $_POST['id_periodo'];
$id_unidade = $_POST['id_unidade'];

// inserir
$sql = "INSERT INTO categoria_profissional (id_categoria, id_unidade, id_periodo, id_profissional) VALUES ('$id_categoria', '$id_unidade', '$id_periodo', '$id_profissional')";
if ($conn->query($sql) === TRUE) {
	// echo 'sucesso';
} else {
	// echo 'erro';
}
// echo $sql;
// voltar
header("Location: categoria-profissional.php?id_profissional=$id_profissional");
exit;
?>
