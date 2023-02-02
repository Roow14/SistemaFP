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
$id_tmp_paciente = $_GET['id_tmp_paciente'];
$NomeCompleto = $_POST['NomeCompleto'];
$Pai = $_POST['Pai'];
$Mae = $_POST['Mae'];




// atualizar
$sql = "UPDATE tmp_paciente SET NomeCompleto = '$NomeCompleto', Pai = '$Pai', Mae = '$Mae' WHERE id_tmp_paciente = '$id_tmp_paciente' ";
if ($conn->query($sql) === TRUE) {
} else {
}

// voltar
header("Location: importar-pacientes.php?id=#$id_tmp_paciente");
exit;
?>
