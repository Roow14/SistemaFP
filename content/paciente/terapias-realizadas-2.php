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
$id_terapia_paciente = $_GET['id_terapia_paciente'];
$HorasTerapiaRealizada = $_POST['HorasTerapiaRealizada'];
$Origem = $_GET['Origem'];

// atualizar
$sql = "UPDATE terapia_paciente SET HorasTerapiaRealizada = '$HorasTerapiaRealizada' WHERE id_terapia_paciente = '$id_terapia_paciente' ";
if ($conn->query($sql) === TRUE) {
} else {
}

// voltar
header("Location: $Origem?id_paciente=$id_paciente");
exit;
?>
