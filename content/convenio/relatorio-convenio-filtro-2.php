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
if (!empty($_POST['id_convenio'])) {
	$id_convenio = $_POST['id_convenio'];
	if ($id_convenio == 99) {
		unset($_SESSION['id_convenio']);
		$_SESSION['FiltroSemConvenio'] = 1;
	} else {
		$_SESSION['id_convenio'] = $id_convenio;
		unset($_SESSION['FiltroSemConvenio']);
	}
} else {
	unset($_SESSION['id_convenio']);
	unset($_SESSION['FiltroSemConvenio']);
}

// voltar
header("Location: relatorio-convenio.php");
exit;
?>