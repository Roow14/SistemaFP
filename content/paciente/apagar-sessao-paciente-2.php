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
$id_sessao_paciente = $_GET['id_sessao_paciente'];
$id_paciente = $_GET['id_paciente'];

// verificar se tem sessão agendada
$sql = "SELECT * FROM sessao WHERE id_sessao_paciente = '$id_sessao_paciente'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
    	// tem, não apagar
		$_SESSION['ErraoApagarSessaoPaciente'] = 'sim';
    }
} else {
	// apagar
	$sqlA = "DELETE FROM sessao_paciente WHERE id_sessao_paciente = '$id_sessao_paciente'";
	if ($conn->query($sqlA) === TRUE) {
	} else {
	}
}

// voltar
header("Location: listar-sessoes.php?id_paciente=$id_paciente");
exit;
