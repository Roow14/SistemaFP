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
$NomeCompleto = $_POST['NomeCompleto'];
$NomeCurto = $_POST['NomeCurto'];

if (empty($_POST['NomeCompleto'])) {
} else {
	// atualizar
	$sql = "UPDATE profissional SET NomeCompleto = '$NomeCompleto' WHERE id_profissional = '$id_profissional' ";
	if ($conn->query($sql) === TRUE) {
		echo $sql;
		echo '<br>';
	} else {
		echo 'erro'.$sql;
		echo '<br>';
	}
}

if (empty($_POST['NomeCurto'])) {
} else {
	// atualizar
	$sql = "UPDATE profissional SET NomeCurto = '$NomeCurto' WHERE id_profissional = '$id_profissional' ";
	if ($conn->query($sql) === TRUE) {
		echo $sql;
		echo '<br>';
	} else {
		echo 'erro'.$sql;
		echo '<br>';
	}
}

// voltar
header("Location: configurar-primeiro-nome-profissionais.php?id=#$id_profissional");
exit;
?>
