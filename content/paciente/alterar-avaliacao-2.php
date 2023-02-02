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
$id_avaliacao = $_GET['id_avaliacao'];
$DataAvaliacao = $_POST['DataAvaliacao'];
$Avaliacao = $_POST['Avaliacao'];
$Avaliacao = str_replace("'","&#39;",$Avaliacao);
$Avaliacao = str_replace('"','&#34;',$Avaliacao);
$TituloAvaliacao = $_POST['TituloAvaliacao'];

// atualizar
$sql = "UPDATE avaliacao SET TituloAvaliacao = '$TituloAvaliacao' WHERE id_avaliacao = '$id_avaliacao' ";
if ($conn->query($sql) === TRUE) {
} else {
}

// atualizar
$sql = "UPDATE avaliacao SET DataAvaliacao = '$DataAvaliacao' WHERE id_avaliacao = '$id_avaliacao' ";
if ($conn->query($sql) === TRUE) {
} else {
}

// atualizar
$sql = "UPDATE avaliacao SET Avaliacao = '$Avaliacao' WHERE id_avaliacao = '$id_avaliacao' ";
if ($conn->query($sql) === TRUE) {
} else {
	// mensagem de alerta
	echo "<script type=\"text/javascript\">
	    alert(\"Erro: o conteúdo não foi alterado.\");
	    window.location = \"listar-avaliacoes.php?id_paciente=$id_paciente\"
	    </script>";
	exit;
}

// voltar
header("Location: listar-avaliacoes.php?id_paciente=$id_paciente");
exit;
?>