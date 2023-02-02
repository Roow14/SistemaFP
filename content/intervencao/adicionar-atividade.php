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
$id_atividade_titulo = $_GET['id_atividade_titulo'];
$NomeAtividade = $_POST['NomeAtividade'];

if (empty($_POST['NomeAtividade'])) {

} else {
	// inserir
	$sql = "INSERT INTO prog_atividade (NomeAtividade, id_atividade_titulo) VALUES ('$NomeAtividade', '$id_atividade_titulo')";
	if ($conn->query($sql) === TRUE) {
		echo 'atividade criada com sucesso.';
	} else {
		echo 'erro ao criar atividade' .$sql;
	}
}

// voltar
header("Location: cadastrar-atividade-1.php?id_atividade_titulo=$id_atividade_titulo");
exit;
?>
 