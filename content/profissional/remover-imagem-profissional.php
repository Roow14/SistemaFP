<?php
if (!isset($_SESSION)) session_start();
$nivel_necessario = 1;
if (!isset($_SESSION['UsuarioID']) OR ($_SESSION['UsuarioNivel'] < $nivel_necessario)) {
session_destroy();
header("Location: ../../index.html"); exit;
}
    
include "../conexao/conexao.php";

// input
$id_midia_profissional = $_GET['id_midia_profissional'];
$id_profissional = $_GET['id_profissional'];

// atualizar dados
$sql = "UPDATE midia_profissional SET id_profissional = NULL WHERE id_midia_profissional = '$id_midia_profissional' ";
if ($conn->query($sql) === TRUE) {
} else {
}

if (empty($_GET['id_profissional'])) {
	// fechar e voltar
	header("Location: midia-profissional.php?id_midia_profissional=$id_midia_profissional");
} else {
	// fechar e voltar
	header("Location: profissional.php?id_profissional=$id_profissional");
}
exit;
?>