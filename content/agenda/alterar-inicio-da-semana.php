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
$id_paciente = $_GET['id_paciente'];
$id_categoria = $_GET['id_categoria'];
$DataAgenda = $_POST['DataAgenda'];

$id_profissional = $_GET['id_profissional'];
$id_periodo = $_GET['id_periodo'];
$id_unidade = $_GET['id_unidade'];

// verificar se o input dia é segunda
// input
$DayWeek = (strftime("%a", strtotime($DataAgenda)));
// verificar se é segunda
if ($DayWeek == 'Mon') {
	$_SESSION['DataAgenda'] = $_POST['DataAgenda'];
} else {
	// mensagem de alerta
	if (isset($_GET['id_paciente'])) {
		echo "<script type=\"text/javascript\">
		    alert(\"Erro: Não é 2ª feira. Selecione uma nova data.\");
		    window.location = \"agenda-paciente.php?id_paciente=$id_paciente&id_categoria=$id_categoria\"
		    </script>";
	} elseif (isset($_GET['id_profissional'])) {
		echo "<script type=\"text/javascript\">
		    alert(\"Erro: Não é 2ª feira. Selecione uma nova data.\");
		    window.location = \"agenda-profissional.php?id_profissional=$id_profissional&id_periodo=$id_periodo&id_unidade=$id_unidade\"
		    </script>";
	} else {
	}
	exit;
}

// voltar
if (isset($_GET['id_paciente'])) {
	header("Location: agenda-paciente.php?id_paciente=$id_paciente&id_categoria=$id_categoria");
} elseif (isset($_GET['id_profissional'])) {
	header("Location: agenda-profissional.php?id_profissional=$id_profissional&id_periodo=$id_periodo&id_unidade=$id_unidade");
} else {
}
exit;
?>
